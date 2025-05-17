<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = Event::query()
            ->with('category')
            ->where('date', '>=', now());

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->date) {
            if ($request->date === 'today') {
                $query->whereDate('date', today());
            } elseif ($request->date === 'week') {
                $query->whereBetween('date', [now(), now()->addWeek()]);
            } elseif ($request->date === 'month') {
                $query->whereBetween('date', [now(), now()->addMonth()]);
            } else {
                $query->whereDate('date', $request->date);
            }
        }

        if ($request->price) {
            if ($request->price === 'free') {
                $query->where('price', 0);
            } elseif ($request->price === 'paid') {
                $query->where('price', '>', 0);
            }
        }

        if ($request->search) {
            $regex = implode('.*', str_split($request->search)); // e.g. 'oo' → 'o.*o'
            $query->where(function ($q) use ($regex) {
                $q->where('title', 'REGEXP', $regex)
                    ->orWhere('description', 'REGEXP', $regex);
            });
        }

        if ($request->sort === 'popular') {
            $query->withCount('bookings')->orderByDesc('bookings_count');
        } else {
            $query->orderBy('date');
        }

        $events = $query->paginate(12);

        $categories = Category::all();

        return view('search', [
            'events' => $events,
            'categories' => $categories,
            'searchParams' => $request->all()
        ]);
    }
}
