;(function () {
    'use strict'

    var HUNKIE_TRACKING_API = '/api/track'
    var STORAGE_KEY = 'hunkie_session_id'
    var HEARTBEAT_INTERVAL = 30000
    var sessionId = localStorage.getItem(STORAGE_KEY)
    var lastBeat = Date.now()
    var beatTimer = null

    function generateId() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
            var r = (Math.random() * 16) | 0
            var v = c === 'x' ? r : (r & 0x3) | 0x8
            return v.toString(16)
        })
    }

    function post(endpoint, data) {
        try {
            var xhr = new XMLHttpRequest()
            xhr.open('POST', HUNKIE_TRACKING_API + '/' + endpoint, true)
            xhr.setRequestHeader('Content-Type', 'application/json')
            xhr.setRequestHeader('Accept', 'application/json')
            xhr.send(JSON.stringify(data))
        } catch (e) {
            // silently fail tracking
        }
    }

    function getUtmParam(name) {
        var match = location.search.match(new RegExp('[?&]' + name + '=([^&]*)'))
        return match ? decodeURIComponent(match[1]) : null
    }

    function identify() {
        if (!sessionId) {
            sessionId = generateId()
            localStorage.setItem(STORAGE_KEY, sessionId)
        }

        post('identify', {
            session_id: sessionId,
            referrer_url: document.referrer || null,
            landing_page: location.pathname + location.search,
            utm_source: getUtmParam('utm_source'),
            utm_medium: getUtmParam('utm_medium'),
            utm_campaign: getUtmParam('utm_campaign'),
        })
    }

    function trackPageview() {
        post('pageview', {
            session_id: sessionId,
            url: location.pathname + location.search,
            page_title: document.title,
            action_type: 'page_view',
        })
    }

    function startHeartbeat() {
        beatTimer = setInterval(function () {
            var now = Date.now()
            var seconds = Math.floor((now - lastBeat) / 1000)
            if (seconds > 0) {
                post('heartbeat', {
                    session_id: sessionId,
                    seconds: seconds,
                })
                lastBeat = now
            }
        }, HEARTBEAT_INTERVAL)
    }

    function init() {
        if (!sessionId) {
            identify()
        }
        trackPageview()
        startHeartbeat()

        // Track history-based navigation (SPA support)
        var lastUrl = location.pathname + location.search
        var origPushState = history.pushState
        history.pushState = function () {
            origPushState.apply(this, arguments)
            var newUrl = location.pathname + location.search
            if (newUrl !== lastUrl) {
                lastUrl = newUrl
                trackPageview()
            }
        }

        window.addEventListener('popstate', function () {
            var newUrl = location.pathname + location.search
            if (newUrl !== lastUrl) {
                lastUrl = newUrl
                trackPageview()
            }
        })

        // Expose for forms to associate contact info
        window.__hunkieTracking = {
            sessionId: sessionId,
            identifyContact: function (data) {
                data.session_id = sessionId
                post('contact', data)
            },
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init)
    } else {
        init()
    }
})()
