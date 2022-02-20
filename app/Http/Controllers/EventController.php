<?php

namespace App\Http\Controllers;

use App\Http\Requests\event\StoreEventRequest;
use App\Http\Requests\event\UpdateEventRequest;
use App\Models\Event;
use App\Models\EventType;
use App\Models\User;
use App\Services\EventService;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function index(
        User $user = null,
        int $day = null,
        int $month = null,
        int $year = null
    ) {
        $this->authorize('index', Event::class);

        $user = $user ?? auth()->user();

        /* no day, month and year specification, date equals last day with events */
        if (is_null($day) && is_null($month) && is_null($year)) {
            $dateOfLastEvent = Event::where('user_id', $user->id)
                ->where('date', '<', now())
                ->orderBy('date', 'desc')
                ->select('date')
                ->first()
                ->date ?? null;

            $date = $dateOfLastEvent
                ? Carbon::create($dateOfLastEvent)
                : now();
        } else {
            /* at last day specified, date set to that day even if there is no events on that date */
            $date = Carbon::createFromDate(
                $year ?? now()->year,
                $month ?? now()->month,
                $day ?? now()->day,
            );
        }

        $events = Event::with('eventType')
            ->where('user_id', $user->id ?? auth()->user()->id)
            ->where('date', $date->toDateString())
            ->get();

        $dayBefore = Event::where('user_id', $user->id ?? auth()->user()->id)
            ->where('date', '<', $date->toDateString())
            ->orderBy('date', 'desc')
            ->select('date')
            ->first()
            ->date ?? null;

        $dayBefore = $dayBefore
            ? Carbon::create($dayBefore)
            : null;

        $dayAfter = Event::where('user_id', $user->id ?? auth()->user()->id)
            ->where('date', '>', $date->toDateString())
            ->orderBy('date', 'asc')
            ->select('date')
            ->first()
            ->date ?? null;

        $dayAfter = $dayAfter
            ? Carbon::create($dayAfter)
            : null;

        return view('event.index', compact(
            'date',
            'user',
            'events',
            'dayBefore',
            'dayAfter'
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function calendar(
        User $user = null,
        int $month = null,
        int $year = null
    ) {
        $user = $user ?? auth()->user();

        $this->authorize('calendar', Event::make([
            'user_id' => $user->id
        ]));

        $currentMonth = Carbon::createFromDate(
            $year ?? now()->year,
            $month ?? now()->month,
            1
        );

        $previousMonth = clone $currentMonth;
        $previousMonth->subMonth();

        $nextMonth = clone $currentMonth;
        $nextMonth->addMonth();

        $events = Event::with('eventType')
            ->where('user_id', $user->id ?? auth()->user()->id)
            ->whereMonth('date', $currentMonth->month )
            ->whereYear('date', $currentMonth->year)
            ->get();

        $eventService = new EventService();
        $timeSpentWorkingByDay = $eventService->TimeSpentWorkingByDay($events);

        return view('event.calendar', compact(
            'user',
            'timeSpentWorkingByDay',
            'currentMonth',
            'previousMonth',
            'nextMonth',
        ));
    }

    /**
     * Show the form for the first step of creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('event.create');
    }

    /**
     * Store a newly created resource in storage (Store second step).
     *
     * @param StoreEventRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(StoreEventRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $event = Event::make([
            'user_id' => $validated['user_id'],
            'event_type_id' => $validated['event_type'],
            'date' => Carbon::parse($validated['event_datetime'])->toDateString(),
            'time' => Carbon::parse($validated['event_datetime'])->toTimeString(),
        ]);

        /* Since it is the EventController Class the policy has to receive an Event Model */
        $this->authorize('store', $event);

        $event->save();

        return redirect()->route('dashboard.index')
            ->with('message', __('Event created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Event $event
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function edit(Event $event)
    {
        $this->authorize('edit', $event);

        return view('event.edit', [
            'event' => $event,
            'user' => User::find($event->user_id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateEventRequest $request
     * @param Event $event
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        $this->authorize('edit', $event);

        $validated = $request->validated();

        $date = Carbon::parse($validated['event_datetime']);

        $event->update([
            'event_type_id' => $validated['event_type'],
            'date' => $date->toDateString(),
            'time' => Carbon::parse($validated['event_datetime'])->toTimeString(),
        ]);

        return redirect()->route('event.index', [
            $event->user_id,
            $date->day,
            $date->month,
            $date->year,
        ])->with('message', __('Event updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Event $event
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(Event $event): RedirectResponse
    {
        $this->authorize('destroy', $event);

        $event->delete();

        return back()->with('message', __('Event deleted'));
    }
}
