<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    /**
     * Display a listing of documents.
     */
    public function index(Request $request)
    {
        $query = Document::with('creator')->latest();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('document_number', 'like', "%{$search}%")
                  ->orWhere('recipient_name', 'like', "%{$search}%")
                  ->orWhere('recipient_phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        $documents = $query->paginate(15)->withQueryString();

        return view('documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new document.
     */
    public function create(Request $request)
    {
        $selectedType = $request->get('type', 'mou');
        $templates = $this->getTemplates();

        return view('documents.create', compact('selectedType', 'templates'));
    }

    /**
     * Store a newly created document in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:mou,agreement,voucher,notice,custom',
            'title' => 'required|string|max:255',
            'recipient_name' => 'nullable|string|max:255',
            'recipient_phone' => 'nullable|string|max:50',
            'recipient_address' => 'nullable|string|max:255',
            'date' => 'required|date',
            'content' => 'required|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'font_family' => 'nullable|string|max:100',
            'font_size' => 'nullable|string|max:20',
        ]);

        $prefix = strtoupper($request->type);
        $dateStr = date('Ymd');
        $countToday = Document::whereDate('created_at', now()->today())->count() + 1;
        $docNumber = sprintf('DOC-%s-%s-%03d', $prefix, $dateStr, $countToday);

        $document = Document::create([
            'document_number' => $docNumber,
            'type' => $request->type,
            'title' => $request->title,
            'recipient_name' => $request->recipient_name,
            'recipient_phone' => $request->recipient_phone,
            'recipient_address' => $request->recipient_address,
            'date' => $request->date,
            'content' => $request->content,
            'notes' => $request->notes,
            'status' => $request->status,
            'font_family' => $request->get('font_family', 'Hind Siliguri'),
            'font_size' => $request->get('font_size', '15px'),
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.documents.show', $document->id)
            ->with('success', 'ডকুমেন্টটি সফলভাবে তৈরি করা হয়েছে!');
    }

    /**
     * Display the specified document.
     */
    public function show($id)
    {
        $document = Document::with('creator')->findOrFail($id);
        $shopSettings = $this->getShopSettings();

        return view('documents.show', compact('document', 'shopSettings'));
    }

    /**
     * Show the form for editing the specified document.
     */
    public function edit($id)
    {
        $document = Document::findOrFail($id);
        $templates = $this->getTemplates();

        return view('documents.edit', compact('document', 'templates'));
    }

    /**
     * Update the specified document in storage.
     */
    public function update(Request $request, $id)
    {
        $document = Document::findOrFail($id);

        $request->validate([
            'type' => 'required|in:mou,agreement,voucher,notice,custom',
            'title' => 'required|string|max:255',
            'recipient_name' => 'nullable|string|max:255',
            'recipient_phone' => 'nullable|string|max:50',
            'recipient_address' => 'nullable|string|max:255',
            'date' => 'required|date',
            'content' => 'required|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'font_family' => 'nullable|string|max:100',
            'font_size' => 'nullable|string|max:20',
        ]);

        $document->update([
            'type' => $request->type,
            'title' => $request->title,
            'recipient_name' => $request->recipient_name,
            'recipient_phone' => $request->recipient_phone,
            'recipient_address' => $request->recipient_address,
            'date' => $request->date,
            'content' => $request->content,
            'notes' => $request->notes,
            'status' => $request->status,
            'font_family' => $request->get('font_family', 'Hind Siliguri'),
            'font_size' => $request->get('font_size', '15px'),
        ]);

        return redirect()->route('admin.documents.show', $document->id)
            ->with('success', 'ডকুমেন্টটি সফলভাবে আপডেট করা হয়েছে!');
    }

    /**
     * Remove the specified document from storage.
     */
    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        $document->delete();

        return redirect()->route('admin.documents.index')
            ->with('success', 'ডকুমেন্টটি সফলভাবে মুছে ফেলা হয়েছে!');
    }

    /**
     * Render print-ready document formatted on official shop letterhead.
     */
    public function print($id)
    {
        $document = Document::with('creator')->findOrFail($id);
        $shopSettings = $this->getShopSettings();

        return view('documents.print', compact('document', 'shopSettings'));
    }

    /**
     * Get shop settings for letterhead header/footer.
     */
    private function getShopSettings()
    {
        $logo = Setting::get('logo', null);
        $logoUrl = null;

        if ($logo && file_exists(public_path('storage/' . $logo))) {
            $logoUrl = asset('storage/' . $logo);
        } else {
            $logoUrl = asset('assets/img/branding/logo.png');
        }

        return [
            'name' => Setting::get('shop_name', 'M3 Mobile Care'),
            'slogan' => Setting::get('shop_slogan', 'Trusted Mobile Repair & Accessories Shop'),
            'address' => Setting::get('address', '(বিগ বাজার) আব্দুল গফফার মার্কেট রাণীশংকৈল, ঠাকুরগাঁও'),
            'phone' => Setting::get('phone', '+8801353106967 / +8801353106966'),
            'email' => Setting::get('email', 'support@m3mobilecares.com'),
            'logo' => $logoUrl,
            'trade_license' => Setting::get('trade_license', 'TRAD/DNCC/012345/2026'),
        ];
    }

    /**
     * Preset HTML templates for documents.
     */
    private function getTemplates()
    {
        return [
            'mou' => [
                'title' => 'সমঝোতা স্মারক (MoU)',
                'content' => '<h3 class="text-center fw-bold text-decoration-underline mb-4">সমঝোতা স্মারক (Memorandum of Understanding)</h3>
<p>অদ্য <strong>'.date('d/m/Y').'</strong> তারিখে প্রথম পক্ষ <strong>M3 Mobile Care</strong> এবং দ্বিতীয় পক্ষ <strong>[দ্বিতীয় পক্ষের নাম]</strong> এর মধ্যে এই দ্বিপাক্ষিক সমঝোতা স্মারকটি সম্পাদিত হলো।</p>

<h4 class="mt-4 fw-bold">১. উদ্দেশ্য:</h4>
<p>উভয় পক্ষ পারস্পরিক ব্যবসায়িক সুবিধা বৃদ্ধি, মোবাইল যন্ত্রাংশ সরবরাহ এবং দক্ষ টেকনিশিয়ান সেবার গুণমান বৃদ্ধির লক্ষ্যে একযোগে কাজ করতে সম্মত হয়েছেন।</p>

<h4 class="mt-4 fw-bold">২. দায়িত্ব ও অঙ্গীকার:</h4>
<ul>
  <li>প্রথম পক্ষ (M3 Mobile Care) গুণগত মানসম্পন্ন যন্ত্রাংশ এবং কারিগরি সহায়তা প্রদান করবে।</li>
  <li>দ্বিতীয় পক্ষ নিয়মিত সময়ে হিসাব সমন্বয় ও ব্যবসায়িক গোপনীয়তা রক্ষা করবেন।</li>
  <li>উভয় পক্ষ সম্মতির ভিত্তিতে যেকোনো জরুরি সিদ্ধান্ত গ্রহণ করতে পারবেন।</li>
</ul>

<h4 class="mt-4 fw-bold">৩. চুক্তির মেয়াদ:</h4>
<p>এই সমঝোতা স্মারকটি স্বাক্ষরের তারিখ থেকে আগামী <strong>১ (এক) বছর</strong> মেয়াদের জন্য কার্যকর বলিয়া গণ্য হইবে।</p>'
            ],
            'agreement' => [
                'title' => 'ব্যবসা / সার্ভিস চুক্তিপত্র (Agreement)',
                'content' => '<h3 class="text-center fw-bold text-decoration-underline mb-4">চুক্তিপত্র (Agreement Deed)</h3>
<p>অদ্য <strong>'.date('d/m/Y').'</strong> তারিখে প্রথম পক্ষ <strong>M3 Mobile Care</strong> (ঠিকানা: দোকান ১২, গ্রাউন্ড ফ্লোর) এবং দ্বিতীয় পক্ষ <strong>[গ্রাহক/পার্টনারের নাম]</strong> (মোবাইল: [মোবাইল নাম্বার]) এর মধ্যে নিম্নে বর্ণিত শর্ত সাপেক্ষে চুক্তিপত্র সম্পাদিত হলো:</p>

<h4 class="mt-4 fw-bold">চুক্তির শর্তাবলী:</h4>
<ol><li><strong>প্রথম শর্ত:</strong> চুক্তি অনুযায়ী সকল সেবার বিবরণ ও মোবাইল মেরামতের ওয়ারেন্টি নীতিমালা প্রযোজ্য হবে।</li><li><strong>দ্বিতীয় শর্ত:</strong> আর্থিক লেনদেন নগদ বা ডিজিটাল পেমেন্ট মাধ্যমে সম্পন্ন হবে এবং বকেয়া থাকলে নির্ধারিত সময়ের মধ্যে তা পরিশোধ যোগ্য।</li><li><strong>তৃতীয় শর্ত:</strong> কোনো প্রকার অনাকাঙ্ক্ষিত বিভ্রাটের ক্ষেত্রে আলোচনার মাধ্যমে সমাধান করা হবে।</li></ol>

<p class="mt-4">অত্র চুক্তিপত্রটি আমরা উভয় পক্ষ সুস্থ মস্তিষ্কে, সজ্ঞান মনের ও অন্যের বিনা প্ররোচনায় পাঠ করিয়া ও মর্ম অবগত হইয়া স্বাক্ষর করিলাম।</p>'
            ],
            'voucher' => [
                'title' => 'টাকা প্রদান / গ্রহণ ভাউচার (Voucher)',
                'content' => '<h3 class="text-center fw-bold text-decoration-underline mb-4">টাকা প্রাপ্তি / প্রদান ভাউচার</h3>
<p><strong>ভাউচার তারিখ:</strong> '.date('d/m/Y').'</p>
<p><strong>প্রাপক/প্রদানকারীর নাম:</strong> [নাম লিখুন]<br><strong>যোগাযোগ:</strong> [মোবাইল নাম্বার]</p>

<table class="table table-bordered mt-3" style="border: 1px solid #ddd; width: 100%;">
  <thead style="background-color: #f5f5f5;">
    <tr>
      <th style="padding: 10px;">ক্রমিক</th>
      <th style="padding: 10px;">বিবরণ (Particulars)</th>
      <th style="padding: 10px; text-align: right;">পরিমাণ (টাকা)</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="padding: 10px; text-align: center;">১</td>
      <td style="padding: 10px;">[এখানে বিলের বিবরণ বা বাবদ লিখুন]</td>
      <td style="padding: 10px; text-align: right;">০.০০</td>
    </tr>
    <tr style="font-weight: bold;">
      <td colspan="2" style="padding: 10px; text-align: right;">সর্বমোট:</td>
      <td style="padding: 10px; text-align: right;">০.০০</td>
    </tr>
  </tbody>
</table>
<p class="mt-3"><strong>কথায় (টাকা):</strong> [কথায় পরিমাণ লিখুন]</p>'
            ],
            'notice' => [
                'title' => 'অফিশিয়াল নোটিশ / বিজ্ঞপ্তি (Official Notice)',
                'content' => '<h3 class="text-center fw-bold text-decoration-underline mb-4">জরুরি নোটিশ / বিজ্ঞপ্তি</h3>
<p class="text-end"><strong>তারিখ:</strong> '.date('d/m/Y').'</p>
<p>এতদ্বারা <strong>M3 Mobile Care</strong>-এর সকল সম্মানিত গ্রাহক, টেকনিশিয়ান ও শুভানুধ্যায়ীদের অবগতির জন্য জানানো যাচ্ছে যে,</p>

<div style="padding: 20px; background-color: #f8f9fa; border-left: 5px solid #7367f0; margin: 20px 0; border-radius: 4px;">
  <p class="mb-0 fs-5">[এখানে আপনার নোটিশের মূল বার্তাটি বিস্তারিতভাবে লিখুন...]</p>
</div>

<p>আপনাদের সার্বিক সহযোগিতা ও বিশ্বস্ততার জন্য ধন্যবাদ।</p>
<p class="mt-4">বিনীত,<br><strong>M3 Mobile Care কর্তৃপক্ষ</strong></p>'
            ],
            'custom' => [
                'title' => 'কাস্টম লেটার / দলিল (Custom Document)',
                'content' => '<h3>বিষয়: [এখানে পত্রে বিষয় লিখুন]</h3>
<p>তারিখ: '.date('d/m/Y').'</p>
<p>জনাব,</p>
<p>[এখানে আপনার ডকুমেন্টের মূল বক্তব্য বা বিস্তারিত বিবরণ লিখুন...]</p>'
            ]
        ];
    }
}
