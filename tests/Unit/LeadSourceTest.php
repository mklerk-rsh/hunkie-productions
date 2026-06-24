<?php

namespace Tests\Unit;

use App\Enums\LeadSource;
use Tests\TestCase;

class LeadSourceTest extends TestCase
{
    public function test_from_referrer_direct()
    {
        $this->assertSame(LeadSource::Direct, LeadSource::fromReferrer(null));
        $this->assertSame(LeadSource::Direct, LeadSource::fromReferrer(''));
    }

    public function test_from_referrer_google_organic()
    {
        $this->assertSame(LeadSource::GoogleOrganic, LeadSource::fromReferrer('https://www.google.com/search?q=hunkie'));
    }

    public function test_from_referrer_google_ads()
    {
        $this->assertSame(LeadSource::GoogleAds, LeadSource::fromReferrer('https://www.googleadservices.com/pagead/aclk?ad=123'));
    }

    public function test_from_referrer_facebook()
    {
        $this->assertSame(LeadSource::Facebook, LeadSource::fromReferrer('https://www.facebook.com/some-post'));
    }

    public function test_from_referrer_instagram()
    {
        $this->assertSame(LeadSource::Instagram, LeadSource::fromReferrer('https://www.instagram.com/p/ABC123/'));
    }

    public function test_from_referrer_linkedin()
    {
        $this->assertSame(LeadSource::LinkedIn, LeadSource::fromReferrer('https://www.linkedin.com/feed/'));
    }

    public function test_from_referrer_twitter()
    {
        $this->assertSame(LeadSource::Twitter, LeadSource::fromReferrer('https://twitter.com/someuser/status/123'));
        $this->assertSame(LeadSource::Twitter, LeadSource::fromReferrer('https://x.com/someuser/status/456'));
    }

    public function test_from_referrer_youtube()
    {
        $this->assertSame(LeadSource::YouTube, LeadSource::fromReferrer('https://www.youtube.com/watch?v=abc123'));
    }

    public function test_from_referrer_fallback_to_referral()
    {
        $this->assertSame(LeadSource::Referral, LeadSource::fromReferrer('https://some-other-site.com/page'));
    }
}
