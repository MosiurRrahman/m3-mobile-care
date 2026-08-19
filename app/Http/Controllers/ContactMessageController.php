<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Services\SmsService;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of customer contact inquiries/messages.
     */
    public function index(Request $request)
    {
        $query = ContactMessage::query();

        // Filter by Status
        if ($request->filled('status') && in_array($request->input('status'), ['unread', 'read', 'replied'])) {
            $query->where('status', $request->input('status'));
        }

        // Search by Name, Phone, or Message Content
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Quick KPI counts
        $totalCount = ContactMessage::count();
        $unreadCount = ContactMessage::where('status', 'unread')->count();
        $readCount = ContactMessage::where('status', 'read')->count();
        $repliedCount = ContactMessage::where('status', 'replied')->count();

        $messages = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('contact-messages.index', compact('messages', 'totalCount', 'unreadCount', 'readCount', 'repliedCount'));
    }

    /**
     * Mark a contact inquiry as read.
     */
    public function markAsRead($id)
    {
        $message = ContactMessage::findOrFail($id);
        if ($message->status === 'unread') {
            $message->update(['status' => 'read']);
        }

        return redirect()->back()->with('success', 'বার্তাটি "Read" হিসেবে চিহ্নিত করা হয়েছে।');
    }

    /**
     * Mark all unread contact inquiries as read.
     */
    public function markAllAsRead()
    {
        ContactMessage::where('status', 'unread')->update(['status' => 'read']);
        return redirect()->back()->with('success', 'সকল অপঠিত বার্তা "Read" হিসেবে চিহ্নিত করা হয়েছে।');
    }

    /**
     * Send direct reply SMS to the customer.
     */
    public function sendReplySms(Request $request, $id)
    {
        $message = ContactMessage::findOrFail($id);

        $request->validate([
            'sms_message' => 'required|string|max:500',
        ]);

        if (empty($message->phone)) {
            return redirect()->back()->with('error', 'কাস্টমারের ফোন নাম্বার পাওয়া যায়নি।');
        }

        $smsText = trim($request->input('sms_message'));
        $result = SmsService::sendSms($message->phone, $smsText, true);

        if ($result['success']) {
            $message->update([
                'status' => 'replied',
                'replied_at' => now(),
                'notes' => ($message->notes ? $message->notes . "\n" : '') . '[' . now()->format('d M Y h:i A') . ' SMS Sent]: ' . $smsText,
            ]);

            return redirect()->back()->with('success', 'কাস্টমারকে সফলভাবে SMS পাঠানো হয়েছে এবং বার্তাটি "Replied" হিসেবে সংরক্ষিত হয়েছে!');
        }

        return redirect()->back()->with('error', 'SMS পাঠানো ব্যর্থ হয়েছে: ' . $result['message']);
    }

    /**
     * Remove the specified message from storage.
     */
    public function destroy($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return redirect()->back()->with('success', 'বার্তাটি সফলভাবে ডিলিট করা হয়েছে।');
    }
}
