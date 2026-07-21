<?php

namespace Tests\Feature;

use App\Helpers\Helpers;
use App\Models\User;
use App\Models\Customer;
use App\Models\Repair;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImageCompressionTest extends TestCase
{
    use RefreshDatabase;

    public function test_image_is_compressed_and_stored()
    {
        Storage::fake('public');

        // Create a large fake image (2000x1500)
        $file = UploadedFile::fake()->image('large_image.jpg', 2000, 1500);

        // Compress and store the image
        $storedPath = Helpers::compressAndStoreImage($file, 'inventory', 'public');

        // Assert file exists
        Storage::disk('public')->assertExists($storedPath);

        // Get stored file path
        $realPath = Storage::disk('public')->path($storedPath);

        // Verify dimensions are resized to maximum of 1200px
        $imageInfo = getimagesize($realPath);
        $this->assertNotEmpty($imageInfo);
        
        $width = $imageInfo[0];
        $height = $imageInfo[1];

        $this->assertLessThanOrEqual(1200, $width);
        $this->assertLessThanOrEqual(1200, $height);
        
        // Assert it maintains aspect ratio: 2000/1500 = 1.333
        // So with width limited to 1200, height should be 1200 / (2000/1500) = 900
        $this->assertEquals(1200, $width);
        $this->assertEquals(900, $height);
    }

    public function test_png_image_retains_transparency_and_is_resized()
    {
        Storage::fake('public');

        // Create a large PNG image
        $file = UploadedFile::fake()->image('transparent.png', 1600, 2000);

        $storedPath = Helpers::compressAndStoreImage($file, 'inventory', 'public');

        Storage::disk('public')->assertExists($storedPath);

        $realPath = Storage::disk('public')->path($storedPath);
        $imageInfo = getimagesize($realPath);
        
        $width = $imageInfo[0];
        $height = $imageInfo[1];

        $this->assertLessThanOrEqual(1200, $width);
        $this->assertLessThanOrEqual(1200, $height);
        $this->assertEquals(960, $width); // 1600 * (1200/2000) = 960
        $this->assertEquals(1200, $height);
    }

    public function test_repair_photos_are_compressed_on_create_and_update()
    {
        Storage::fake('public');

        $superAdmin = User::factory()->create([
            'role' => 'super_admin',
            'branch' => 'Dhaka Main',
        ]);

        // 1. Test creation with compression
        $file1 = UploadedFile::fake()->image('photo1.jpg', 2000, 1500);
        $file2 = UploadedFile::fake()->image('photo2.png', 1500, 2000);

        $payload = [
            'customer_name' => 'Test Customer',
            'customer_phone' => '01999888777',
            'customer_address' => 'Dhaka, Bangladesh',
            'device_brand' => 'Apple',
            'device_model' => 'iPhone 13',
            'serial_imei' => '123456789012345',
            'issue_description' => 'Broken screen',
            'repair_charge' => 5000.00,
            'status' => 'pending',
            'device_photos' => [$file1, $file2]
        ];

        $response = $this->actingAs($superAdmin)
            ->post(route('admin.repairs.store'), $payload);

        $response->assertRedirect(route('admin.repairs.index'));

        // Assert database record exists and photos are stored
        $repair = Repair::where('device_model', 'iPhone 13')->first();
        $this->assertNotNull($repair);
        $this->assertCount(2, $repair->device_photos);

        foreach ($repair->device_photos as $storedPath) {
            Storage::disk('public')->assertExists($storedPath);
            
            // Verify dimensions are resized to maximum of 1200px
            $realPath = Storage::disk('public')->path($storedPath);
            $imageInfo = getimagesize($realPath);
            $this->assertLessThanOrEqual(1200, $imageInfo[0]);
            $this->assertLessThanOrEqual(1200, $imageInfo[1]);
        }

        // 2. Test update with new photo appending and compression
        $file3 = UploadedFile::fake()->image('photo3.jpg', 1800, 1800);

        $updatePayload = [
            'customer_id' => $repair->customer_id,
            'device_brand' => 'Apple',
            'device_model' => 'iPhone 13 Pro',
            'serial_imei' => '123456789012345',
            'issue_description' => 'Broken screen and battery replacement',
            'repair_charge' => 7000.00,
            'status' => 'repairing',
            'device_photos' => [$file3]
        ];

        $updateResponse = $this->actingAs($superAdmin)
            ->put(route('admin.repairs.update', $repair->id), $updatePayload);

        $updateResponse->assertRedirect(route('admin.repairs.show', $repair->id));

        $repair->refresh();
        $this->assertEquals('iPhone 13 Pro', $repair->device_model);
        // Should have 3 photos total now
        $this->assertCount(3, $repair->device_photos);

        // Verify the newly added photo is compressed and stored
        $newPhotoPath = $repair->device_photos[2];
        Storage::disk('public')->assertExists($newPhotoPath);
        $realPath3 = Storage::disk('public')->path($newPhotoPath);
        $imageInfo3 = getimagesize($realPath3);
        $this->assertLessThanOrEqual(1200, $imageInfo3[0]);
        $this->assertLessThanOrEqual(1200, $imageInfo3[1]);
    }
}
