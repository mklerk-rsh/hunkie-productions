<?php

namespace Tests\Feature\Models;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_value_returns_default()
    {
        $this->assertNull(Setting::getValue('non_existent'));
        $this->assertEquals('default', Setting::getValue('non_existent', 'default'));
    }

    public function test_set_value_creates_or_updates()
    {
        Setting::setValue('test_key', 'test_value', 'testing');
        $this->assertEquals('test_value', Setting::getValue('test_key'));

        Setting::setValue('test_key', 'updated_value');
        $this->assertEquals('updated_value', Setting::getValue('test_key'));
    }

    public function test_by_group_scope()
    {
        Setting::setValue('key1', 'val1', 'group_a');
        Setting::setValue('key2', 'val2', 'group_a');
        Setting::setValue('key3', 'val3', 'group_b');

        $this->assertEquals(2, Setting::byGroup('group_a')->count());
    }
}
