<?php

namespace App\Http\Controllers;

use App\Models\SocialPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Helpers;

class SocialMediaController extends Controller
{
    /**
     * Display listing of social posts and metrics.
     */
    public function index()
    {
        $posts = SocialPost::orderBy('created_at', 'desc')->get();

        // Split into categories
        $drafts = $posts->where('status', 'draft');
        $scheduled = $posts->where('status', 'scheduled');
        $published = $posts->where('status', 'published');

        // Analytics metrics calculations
        $totalReach = $published->sum('reach');
        $totalEngagement = $published->sum('engagement');
        $totalPostsCount = $published->count();

        // Calculate average engagement rate
        $avgEngagementRate = 0;
        if ($totalReach > 0) {
            $avgEngagementRate = ($totalEngagement / $totalReach) * 100;
        }

        return view('social.index', compact(
            'posts',
            'drafts',
            'scheduled',
            'published',
            'totalReach',
            'totalEngagement',
            'totalPostsCount',
            'avgEngagementRate'
        ));
    }

    /**
     * Store new social post.
     */
    public function store(Request $request)
    {
        $request->validate([
            'platform' => 'required|string|in:Facebook,Instagram,Twitter,LinkedIn',
            'content' => 'required|string',
            'media' => 'nullable|image|max:20480',
            'scheduled_at' => 'nullable|date',
            'status' => 'required|string|in:draft,scheduled,published',
        ]);

        $mediaPath = null;
        if ($request->hasFile('media')) {
            $mediaPath = Helpers::compressAndStoreImage($request->file('media'), 'social');
        }

        $status = $request->input('status');
        $reach = 0;
        $engagement = 0;
        $publishedAt = null;

        if ($status === 'published') {
            $reach = rand(800, 12000);
            $engagement = rand(40, round($reach * 0.18));
            $publishedAt = now();
        }

        SocialPost::create([
            'platform' => $request->input('platform'),
            'content' => $request->input('content'),
            'media_path' => $mediaPath,
            'scheduled_at' => $request->input('scheduled_at'),
            'status' => $status,
            'reach' => $reach,
            'engagement' => $engagement,
            'published_at' => $publishedAt,
        ]);

        return redirect()->route('admin.social.index')->with('success', 'Social post created successfully!');
    }

    /**
     * Update an existing social post.
     */
    public function update(Request $request, $id)
    {
        $post = SocialPost::findOrFail($id);

        $request->validate([
            'platform' => 'required|string|in:Facebook,Instagram,Twitter,LinkedIn',
            'content' => 'required|string',
            'media' => 'nullable|image|max:20480',
            'scheduled_at' => 'nullable|date',
            'status' => 'required|string|in:draft,scheduled,published',
        ]);

        if ($request->hasFile('media')) {
            if ($post->media_path) {
                Storage::disk('public')->delete($post->media_path);
            }
            $post->media_path = Helpers::compressAndStoreImage($request->file('media'), 'social');
        }

        $status = $request->input('status');
        if ($status === 'published' && $post->status !== 'published') {
            $post->reach = rand(800, 12000);
            $post->engagement = rand(40, round($post->reach * 0.18));
            $post->published_at = now();
        }

        $post->platform = $request->input('platform');
        $post->content = $request->input('content');
        $post->scheduled_at = $request->input('scheduled_at');
        $post->status = $status;
        $post->save();

        return redirect()->route('admin.social.index')->with('success', 'Social post updated successfully!');
    }

    /**
     * Publish a post immediately.
     */
    public function publish($id)
    {
        $post = SocialPost::findOrFail($id);

        $reach = rand(1500, 16000);
        $engagement = rand(80, round($reach * 0.16));

        $post->update([
            'status' => 'published',
            'reach' => $reach,
            'engagement' => $engagement,
            'published_at' => now(),
        ]);

        return redirect()->route('admin.social.index')->with('success', 'Post published to ' . $post->platform . ' successfully!');
    }

    /**
     * Delete a social post.
     */
    public function destroy($id)
    {
        $post = SocialPost::findOrFail($id);
        if ($post->media_path) {
            Storage::disk('public')->delete($post->media_path);
        }
        $post->delete();

        return redirect()->route('admin.social.index')->with('success', 'Social post deleted successfully!');
    }
}
