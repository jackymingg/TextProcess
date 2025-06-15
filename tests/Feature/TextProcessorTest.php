<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TextProcessorTest extends TestCase
{
    /**
     *測試文字反轉
     */
    public function test_text_process_api_basic_functionality()
    {
        $response = $this->postJson('/api/text-process', [
            'text' => 'Hello World',
            'operations' => ['reverse']
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'original_text' => 'Hello World',
                     'processed_text' => 'dlroW olleH',
                     'operations' => ['reverse']
                 ]);
    }

    /**
     * 測試大寫轉換
     */
    public function test_text_process_api_uppercase()
    {
        $response = $this->postJson('/api/text-process', [
            'text' => 'Hello World',
            'operations' => ['uppercase']
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'original_text' => 'Hello World',
                     'processed_text' => 'HELLO WORLD',
                     'operations' => ['uppercase']
                 ]);
    }

    /**
     * 測試小寫轉換
     */
    public function test_text_process_api_lowercase()
    {
        $response = $this->postJson('/api/text-process', [
            'text' => 'Hello World',
            'operations' => ['lowercase']
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'original_text' => 'Hello World',
                     'processed_text' => 'hello world',
                     'operations' => ['lowercase']
                 ]);
    }

    /**
     * 測試移除空格
     */
    public function test_text_process_api_remove_spaces()
    {
        $response = $this->postJson('/api/text-process', [
            'text' => 'Hello World',
            'operations' => ['remove_spaces']
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'original_text' => 'Hello World',
                     'processed_text' => 'HelloWorld',
                     'operations' => ['remove_spaces']
                 ]);
    }

    /**
     * 測試多重操作
     */
    public function test_text_process_api_multiple_operations()
    {
        $response = $this->postJson('/api/text-process', [
            'text' => 'Hello World',
            'operations' => ['uppercase', 'reverse']
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'original_text' => 'Hello World',
                     'processed_text' => 'DLROW OLLEH',
                     'operations' => ['uppercase', 'reverse']
                 ]);
    }

    /**
     * 驗證缺少文字參數
     */
    public function test_text_process_api_missing_text()
    {
        $response = $this->postJson('/api/text-process', [
            'operations' => ['reverse']
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['text']);
    }

    /**
     * 驗證缺少操作參數
     */
    public function test_text_process_api_missing_operations()
    {
        $response = $this->postJson('/api/text-process', [
            'text' => 'Hello World'
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['operations']);
    }

    /**
     * 驗證空的操作陣列
     */
    public function test_text_process_api_with_empty_operations()
    {
        $response = $this->postJson('/api/text-process', [
            'text' => 'Hello World',
            'operations' => []
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['operations']);
    }

    /**
     * 驗證無效的操作
     */
    public function test_text_process_api_with_invalid_operation()
    {
        $response = $this->postJson('/api/text-process', [
            'text' => 'Hello World',
            'operations' => ['invalid_operation']
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['operations.0']);
    }

    /**
     * 驗證空文字
     */
    public function test_text_process_api_with_empty_text()
    {
        $response = $this->postJson('/api/text-process', [
            'text' => '',
            'operations' => ['reverse']
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['text']);
    }

    /**
     * 驗證文字不是字串
     */
    public function test_text_process_api_with_non_string_text()
    {
        $response = $this->postJson('/api/text-process', [
            'text' => 123,
            'operations' => ['reverse']
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['text']);
    }

    /**
     * 驗證操作不是陣列
     */
    public function test_text_process_api_with_non_array_operations()
    {
        $response = $this->postJson('/api/text-process', [
            'text' => 'Hello World',
            'operations' => 'reverse'
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['operations']);
    }

    /**
     * 驗證複雜的多重操作順序
     */
    public function test_text_process_api_complex_operations()
    {
        $response = $this->postJson('/api/text-process', [
            'text' => 'Hello World',
            'operations' => ['remove_spaces', 'lowercase', 'reverse']
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'original_text' => 'Hello World',
                     'processed_text' => 'dlrowolleh',
                     'operations' => ['remove_spaces', 'lowercase', 'reverse']
                 ]);
    }
}