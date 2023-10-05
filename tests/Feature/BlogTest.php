<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Blog;


class BlogTest extends TestCase
{
    use WithFaker;

    public function test_page_blog_without_login(): void
    {
        $response = $this->get(route('blogs'));

        $response->assertStatus(302);
        $response->assertRedirect('login');
    }

    public function test_page_blog_with_login(): void
    {
        $this->actingAs($user = User::factory()->create());

        $response = $this->get(route('blogs'));

        $response->assertStatus(200);
    }

    public function test_visit_create_page(): void
    {
        $this->actingAs($user = User::factory()->create());
        $response = $this->get(route('blogs.create'));

        $response->assertStatus(200);
    }

    public function test_store_validate_title(): void
    {
        $this->actingAs($user = User::factory()->create());
        $response = $this->post(route('blogs.store'), [
            'title' => '',
            'slug' => $this->faker->text,
            'content' => $this->faker->paragraph(100)
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_store_success(): void
    {
        $this->actingAs($user = User::factory()->create());
        $response = $this->post(route('blogs.store'), [
            'title' => $this->faker->text,
            'slug' => $this->faker->text,
            'content' => $this->faker->paragraph(100)
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('blogs'));
    }

    public function test_edit_form_success(): void
    {
        $this->actingAs($user = User::factory()->create());
        $blog = Blog::factory()->create();
        $response = $this->get(route('blogs.edit', $blog->id));

        $response->assertStatus(200);
    }

    public function test_update_blog_success(): void
    {
        $this->actingAs($user = User::factory()->create());
        $blog = Blog::factory()->create();
        $newTitle = 'update blog unit test';
        $response = $this->put(route('blogs.update', $blog->id), [
            'id' => $blog->id,
            'title' => $newTitle,
            'slug' => $blog->slug,
            'content' => $blog->content
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success', 'Blog has been updated.');
    }

    public function test_delete_blog_success(): void
    {
        $this->actingAs($user = User::factory()->create());
        $blog = Blog::factory()->create();
        $response = $this->delete(route('blogs.destroy', $blog->id));
        $response->assertStatus(302);
        $response->assertSessionHas('success', 'Blog has been deleted.');
    }

    public function test_searching_blog_success(): void
    {
        $this->actingAs($user = User::factory()->create());
        $blog = Blog::factory()->create(['title' => 'searchexample']);
        $blog2 = Blog::factory()->create(['title' => 'searchexample2']);
        $blog3 = Blog::factory()->create(['title' => 'searchexample3']);

        $response = $this->get('/blogs?search=searchexample');
        $response->assertStatus(200);
        $response->assertSee('searchexample');
    }

    public function test_unique_slug_store_success(): void
    {
        $this->actingAs($user = User::factory()->create());
        $blog = Blog::factory()->create([
            'title' => $this->faker->text,
            'slug' => $this->faker->text,
            'content' => $this->faker->paragraph(20)
        ]);

        $response = $this->post(route('blogs.store'), [
            'title' => $this->faker->text,
            'slug' => $blog->slug,
            'content' => $this->faker->paragraph(20)
        ]);

        $response->assertSessionHasErrors('slug');
    }

    public function test_unique_slug_update_success(): void
    {
        $this->actingAs($user = User::factory()->create());
        $blog = Blog::factory()->create([
            'title' => $this->faker->text,
            'slug' => $this->faker->text,
            'content' => $this->faker->paragraph(20)
        ]);

        $response = $this->put(route('blogs.update', $blog->id), [
            'title' => $this->faker->text,
            'slug' => $blog->slug,
            'content' => $this->faker->paragraph(20)
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success', 'Blog has been updated.');
    }
}
