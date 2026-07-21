<?php

namespace App\Traits;

use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait LogsActivity
{
    /**
     * Boot the trait and register model events.
     */
    protected static function bootLogsActivity()
    {
        static::created(function (Model $model) {
            static::logActivity($model, 'created');
        });

        static::updated(function (Model $model) {
            static::logActivity($model, 'updated');
        });

        static::deleted(function (Model $model) {
            static::logActivity($model, 'deleted');
        });
    }

    /**
     * Record activity log in database.
     */
    protected static function logActivity(Model $model, string $action)
    {
        // Only log if a user is authenticated (e.g. staff member)
        if (!auth()->check()) {
            return;
        }

        static $userCache = [];
        static $customerCache = [];

        $user = auth()->user();
        $changes = [];
        $description = '';
        $modelName = class_basename($model);

        // Define which fields to track and how to display their labels
        $trackedFields = [
            // User model fields
            'role' => 'Role',
            'permissions' => 'Permissions',
            'password' => 'Password',
            'email' => 'Email',
            'branch' => 'Branch',
            // Repair model fields - FULL tracking
            'status' => 'Status',
            'estimated_cost' => 'Estimated Cost',
            'actual_cost' => 'Actual Cost',
            'advance_payment' => 'Advance Payment',
            'assigned_technician_id' => 'Assigned Technician',
            'customer_id' => 'Customer',
            'device_brand' => 'Device Brand',
            'device_model' => 'Device Model',
            'serial_imei' => 'Serial/IMEI Number',
            'issue_description' => 'Issue Description',
            'password_pattern' => 'Pattern/Password',
            'technician_notes' => 'Technician Notes',
            'device_checklist' => 'Device Checklist',
            'device_photos' => 'Device Photos',
            'commission_type' => 'Commission Type',
            'commission_rate' => 'Commission Rate',
            'commission_amount' => 'Commission Amount',
            'used_parts' => 'Installed Spare Parts',
            'repair_charge' => 'Repair Charge',
            'advance_payment_method' => 'Advance Payment Method',
            'payment_method' => 'Final Payment Method',
            'cash_received' => 'Cash Received',
            'change_returned' => 'Change Returned',
            // SocialPost model fields
            'platform' => 'Platform',
            'content' => 'Content',
            'media_path' => 'Media file',
            // Expense model fields
            'amount' => 'Expense Amount',
            'category' => 'Expense Category',
            'register_type' => 'Cash Register Source',
            // Purchase model fields
            'total_amount' => 'Purchase Amount',
            // InventoryItem model fields
            'quantity' => 'Stock Quantity',
            'alert_quantity' => 'Alert Threshold',
            'purchase_price' => 'Purchase Price',
            'sale_price' => 'Sale Price',
            'discount_value' => 'Discount Value',
        ];

        if ($action === 'updated') {
            $dirty = $model->getDirty();
            
            // Check if any of the dirty fields are in our tracked list
            foreach ($dirty as $key => $newValue) {
                if (array_key_exists($key, $trackedFields)) {
                    $oldValue = $model->getOriginal($key);
                    
                    // Don't log if values are practically equivalent (e.g. null vs empty string, or numeric equivalence)
                    if ($oldValue == $newValue) {
                        continue;
                    }

                    $changes[$key] = [
                        'old' => $oldValue,
                        'new' => $newValue,
                    ];
                }
            }

            if (empty($changes)) {
                return; // No relevant tracked fields were changed
            }
        }

        // Create human-readable description
        if ($action === 'created') {
            if ($modelName === 'Repair') {
                $description = "created Job Card (Ticket: {$model->ticket_id}) for {$model->device_brand} {$model->device_model}";
            } elseif ($modelName === 'SocialPost') {
                $description = "created a new post for {$model->platform}";
            } elseif ($modelName === 'Expense') {
                $description = "created Expense of category '{$model->category}' with amount " . number_format(floatval($model->amount), 2) . " BDT";
            } elseif ($modelName === 'Purchase') {
                $description = "created Purchase Record #{$model->purchase_no} with total " . number_format(floatval($model->total_amount), 2) . " BDT";
            } elseif ($modelName === 'InventoryItem') {
                $description = "created Inventory Item '{$model->name}' (SKU: {$model->sku}) with quantity {$model->quantity}";
            } elseif ($modelName === 'User') {
                $description = "created User account '{$model->name}' (Email: {$model->email}, Role: {$model->role})";
            } else {
                $description = "created a new {$modelName}";
            }
        } elseif ($action === 'deleted') {
            if ($modelName === 'Repair') {
                $description = "deleted Job Card (Ticket: {$model->ticket_id}) for {$model->device_brand} {$model->device_model}";
            } elseif ($modelName === 'SocialPost') {
                $description = "deleted a post for {$model->platform}";
            } elseif ($modelName === 'Expense') {
                $description = "deleted Expense of category '{$model->category}' worth " . number_format(floatval($model->amount), 2) . " BDT";
            } elseif ($modelName === 'Purchase') {
                $description = "deleted Purchase Record #{$model->purchase_no} worth " . number_format(floatval($model->total_amount), 2) . " BDT";
            } elseif ($modelName === 'InventoryItem') {
                $description = "deleted Inventory Item '{$model->name}' (SKU: {$model->sku})";
            } elseif ($modelName === 'User') {
                $description = "deleted User account '{$model->name}' (Email: {$model->email})";
            } else {
                $description = "deleted a {$modelName}";
            }
        } elseif ($action === 'updated') {
            $descParts = [];
            foreach ($changes as $field => $values) {
                $label = $trackedFields[$field] ?? $field;
                $oldVal = $values['old'];
                $newVal = $values['new'];

                // Safe array to string conversion
                if (is_array($oldVal)) {
                    $oldVal = json_encode($oldVal);
                }
                if (is_array($newVal)) {
                    $newVal = json_encode($newVal);
                }

                // Handle special formatting for user-friendly output
                if ($field === 'assigned_technician_id') {
                    if ($oldVal && !isset($userCache[$oldVal])) {
                        $userCache[$oldVal] = User::find($oldVal)?->name ?? 'Unknown';
                    }
                    if ($newVal && !isset($userCache[$newVal])) {
                        $userCache[$newVal] = User::find($newVal)?->name ?? 'Unknown';
                    }
                    $oldVal = $oldVal ? ($userCache[$oldVal] ?? 'Unknown') : 'None';
                    $newVal = $newVal ? ($userCache[$newVal] ?? 'Unknown') : 'None';
                } elseif ($field === 'customer_id') {
                    if ($oldVal && !isset($customerCache[$oldVal])) {
                        $customerCache[$oldVal] = Customer::find($oldVal)?->name ?? 'Unknown';
                    }
                    if ($newVal && !isset($customerCache[$newVal])) {
                        $customerCache[$newVal] = Customer::find($newVal)?->name ?? 'Unknown';
                    }
                    $oldVal = $oldVal ? ($customerCache[$oldVal] ?? 'Unknown') : 'None';
                    $newVal = $newVal ? ($customerCache[$newVal] ?? 'Unknown') : 'None';
                } elseif ($field === 'status') {
                    $oldVal = ucfirst(str_replace('_', ' ', $oldVal ?? ''));
                    $newVal = ucfirst(str_replace('_', ' ', $newVal ?? ''));
                } elseif ($field === 'password') {
                    $oldVal = '[hidden]';
                    $newVal = '[changed]';
                } elseif ($field === 'permissions') {
                    $oldVal = is_array($oldVal) ? implode(', ', array_keys(array_filter($oldVal))) : 'None';
                    $newVal = is_array($newVal) ? implode(', ', array_keys(array_filter($newVal))) : 'None';
                    if (empty($oldVal)) $oldVal = 'None';
                    if (empty($newVal)) $newVal = 'None';
                } elseif ($field === 'role') {
                    $oldVal = ucfirst(str_replace('_', ' ', $oldVal ?? ''));
                    $newVal = ucfirst(str_replace('_', ' ', $newVal ?? ''));
                } elseif (in_array($field, ['estimated_cost', 'actual_cost', 'advance_payment', 'amount', 'total_amount', 'discount', 'payable_amount', 'paid_amount', 'due_amount', 'purchase_price', 'sale_price', 'discount_value', 'commission_amount', 'cash_received', 'change_returned'])) {
                    $oldVal = number_format(floatval($oldVal), 2) . ' BDT';
                    $newVal = number_format(floatval($newVal), 2) . ' BDT';
                }

                $descParts[] = "{$label} from '{$oldVal}' to '{$newVal}'";
            }

            if ($modelName === 'Repair') {
                $description = "updated Job Card (Ticket: {$model->ticket_id}): " . implode(', ', $descParts);
            } elseif ($modelName === 'SocialPost') {
                $description = "updated post metrics/content for {$model->platform}: " . implode(', ', $descParts);
            } elseif ($modelName === 'Expense') {
                $description = "updated Expense (Category: {$model->category}): " . implode(', ', $descParts);
            } elseif ($modelName === 'Purchase') {
                $description = "updated Purchase Record #{$model->purchase_no}: " . implode(', ', $descParts);
            } elseif ($modelName === 'InventoryItem') {
                $description = "updated Inventory Item '{$model->name}' (SKU: {$model->sku}): " . implode(', ', $descParts);
            } elseif ($modelName === 'User') {
                $description = "updated User account '{$model->name}': " . implode(', ', $descParts);
            } else {
                $description = "updated {$modelName}: " . implode(', ', $descParts);
            }
        }

        // Save activity log
        ActivityLog::create([
            'user_id' => $user->id,
            'loggable_type' => get_class($model),
            'loggable_id' => $model->id,
            'action' => $action,
            'changes' => $changes,
            'description' => Str::limit($description, 950),
            'ip_address' => request()->ip(),
        ]);
    }
}
