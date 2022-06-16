<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class EventController extends Controller
{
    /**
     * Display a listing of the events.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $eventType = 'All events';
        if ($request->has('key')) {
            $keyword = $request->input('key');
            $today = Carbon::today()->format('Y-m-d');
            switch ($keyword) {
                case('finished'):
                    $events = Event::where('is_completed', true)->orderBy('start_date', 'ASC')->get();
                    $eventType = 'Finished events';
                    break;
                case('upcoming'):
                    $events = Event::where('start_date', '>=', $today)->orderBy('start_date', 'ASC')->get();
                    $eventType = 'Upcoming Events';
                    break;
                case('upcoming-in-7'):
                    $dateAfterSevenDays = Carbon::today()->addDays(7)->format('Y-m-d');
                    $events = Event::whereBetween('start_date', [$today, $dateAfterSevenDays])->orderBy('start_date', 'ASC')->get();
                    $eventType = 'Upcoming events within 7 days';
                    break;
                case('finished-of-7'):
                    $dateBeforeSevenDays = Carbon::today()->subDays(7)->format('Y-m-d');
                    $events = Event::whereBetween('end_date', [$dateBeforeSevenDays, $today])->orderBy('start_date', 'ASC')->get();
                    $eventType = 'Finished events of the last 7 days';
                    break;
                default:
                    $events = Event::orderBy('start_date', 'ASC')->get();
            }
        } else {
            $events = Event::orderBy('start_date', 'ASC')->get();
        }
        return view('events.index', compact('events', 'eventType'));
    }

    /**
     * Show the form for creating a new event.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EventRequest $request
     * @return RedirectResponse
     */
    public function store(EventRequest $request): RedirectResponse
    {
        $input = $request->all();
        $eventData = $this->manipulateDateRange($input['date_range']);
        $event = Event::create([
            'title' => $input['title'],
            'start_date' => $eventData['start_date'],
            'end_date' => $eventData['end_date'],
            'description' => $input['description'],
            'is_completed' => $eventData['is_complete']
        ]);

        if ($event) {
            Alert::toast('Event created successfully.', 'success');
        } else {
            Alert::toast('Sorry, there was an error', 'error');
        }
        return redirect()->route('event.index');
    }

    /**
     * Display the specified Event.
     *
     * @param int $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function show(int $id)
    {
        $event = Event::find($id);
        if ($event) {
            return view('events.show', compact('event'));
        } else {
            Alert::toast('Sorry, there was an error', 'error');
            return redirect()->route('event.index');
        }
    }

    /**
     * Show the form for editing the specified Event.
     *
     * @param int $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function edit(int $id)
    {
        $event = Event::find($id);
        if ($event) {
            return view('events.edit', compact('event'));
        } else {
            Alert::toast('Sorry, there was an error', 'error');
            return redirect()->route('event.index');
        }
    }

    /**
     * Update the specified event in storage.
     *
     * @param EventRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(EventRequest $request, int $id): RedirectResponse
    {
        $input = $request->all();
        $eventData = $this->manipulateDateRange($input['date_range']);
        $event = Event::whereId($id)->update([
            'title' => $input['title'],
            'start_date' => $eventData['start_date'],
            'end_date' => $eventData['end_date'],
            'description' => $input['description'],
            'is_completed' => $eventData['is_complete']
        ]);

        if ($event) {
            Alert::toast('Event edited successfully.', 'success');
        } else {
            Alert::toast('Sorry, there was an error', 'error');
        }
        return redirect()->route('event.index');
    }


    /**
     * Delete the specified event in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {
        $input = $request->all();
        $eventId = $input['eventId'];
        $event = Event::find($eventId);
        if ($event) {
            $event->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Event deleted successfully.'
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Sorry, there was an error'
            ]);
        }
    }

    /**
     * @param string $dateRange
     * @return array
     */
    public function manipulateDateRange(string $dateRange): array
    {
        $date = explode('to', $dateRange);
        $start_date = str_replace(" ", "", $date[0]);
        $end_date = str_replace(" ", "", $date[1]);
        $is_completed = false;

        $today = Carbon::now()->format('Y-m-d');
        if ($today > $end_date) {
            $is_completed = true;
        }

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['is_complete'] = $is_completed;

        return $data;
    }
}
