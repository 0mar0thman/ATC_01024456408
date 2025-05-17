<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('category')->latest()->get();
        $categories = Category::all();
        return view("events.index", compact("events", "categories"));
    }

    public function create()
    {
        $categories = Category::all();
        return view("events.create", compact("categories"));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date|after:today',
            'venue' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'image.mimes' => 'صيغة الصورة يجب أن تكون jpeg, png, jpg, gif',
            'image.required' => 'الصورة مطلوبه',
        ]);

        // 2. رفع الصورة إن وجدت
        $file_name = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_name = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());

            $destinationPath = public_path('Attachments/Events');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $image->move($destinationPath, $file_name);
        }

        // 3. حفظ الفعالية
        Event::create([
            'title' => $request->title,
            'description' => $request->description ?? 'لا يوجد وصف',
            'category_id' => $request->category_id,
            'date' => $request->date,
            'venue' => $request->venue,
            'price' => $request->price,
            'is_featured' => $request->is_featured ?? 0,
            'capacity' => $request->capacity,
            'image' => $file_name, // 👈 هيتخزن هنا لو الصورة موجودة
        ]);

        session()->flash('Add', 'تم إضافة الفعالية بنجاح');
        return redirect()->route('events.index');
    }

    public function show($id)
    {
        $event = Event::with('category')->findOrFail($id);
        return view('events.show', compact('event'));
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $categories = Category::all();
        return view("events.edit", compact("event", "categories"));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
            'venue' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'image.mimes' => 'صيغة الصورة يجب ان تكون jpeg, png, jpg, gif',
        ]);

        $event = Event::findOrFail($id);

        $imagePath = $event->image;
        if ($request->hasFile('image')) {
            // 2. استلام الملف الجديد
            $image = $request->file('image');

            // 3. تجهيز الاسم الجديد
            $file_name = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());

            // 4. مسار التخزين
            $destinationPath = public_path('Attachments/Events');

            // 5. حذف الصورة القديمة إذا كانت موجودة
            $old_file = $destinationPath . '/' . $event->image;
            if (!empty($event->image) && file_exists($old_file) && is_file($old_file)) {
                unlink($old_file);
            }

            // 6. نقل الملف الجديد
            $image->move($destinationPath, $file_name);
        }

        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'date' => $request->date,
            'venue' => $request->venue,
            'price' => $request->price,
            'is_featured' => $request->is_featured ?? 0,
            'capacity' => $request->capacity,
            'image' => $file_name ?? "",
        ]);

        session()->flash('Edit', 'تم تعديل الفعالية بنجاح');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        // حذف الصورة المرفقة
        $file_path = public_path('Attachments/Events/' . $event->image);
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        $event->delete();

        session()->flash('delete', 'تم حذف الفعالية بنجاح');
        return back();
    }

    public function sortDate(Request $request)
    {
        $query = Event::query();

        $query->where('date', '>=', now());

        // تطبيق الفرز حسب الطلب
        if ($request->sort === 'date') {
            $query->orderBy('date', 'asc');
        } elseif ($request->sort === 'popular') {
            $query->orderBy('capacity', 'desc'); // أو معيار شعبية آخر
        } else {
            // لو مفيش فرز محدد، ممكن ترتب حسب التاريخ تصاعدي بشكل افتراضي
            $query->orderBy('date', 'asc');
        }

        $events = $query->paginate(10)->appends(['sort' => $request->sort]);

        // فقط الفعاليات القادمة
        return view('home_user', compact('events'));
    }
}
