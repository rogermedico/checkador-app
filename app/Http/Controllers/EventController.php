<?php

namespace App\Http\Controllers;

use App\Http\Requests\event\ProcessFirstStepReservationRequest;
use App\Http\Requests\event\ProcessSecondStepReservationRequest;
use App\Http\Requests\event\StoreEventRequest;
use App\Http\Requests\event\UpdateEventRequest;
use App\Models\Event;
use App\Models\EventType;
use App\Models\Reservation;
use App\Models\Session;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function index()
    {
        $this->authorize('index', Event::class);

        /**
         * s'ha d'acabar de pensar com ha de ser aquesta pantalla
         * en principi hi haurà un selector de dia i es mostraran
         * tots els events del dia seleccionat amb botons per eliminar-los
         * o editar-los.
         */

        echo 'index';
//        if (Gate::denies('index', auth()->user())) {
//            return redirect()->route('user.reservations.show', auth()->user());
//        }
//
//        $reservations = [];
//        foreach (Reservation::orderBy('row')->orderBy('column')->get() as $reservation) {
//            $session = Session::find($reservation['session_id']);
//            $user = User::find($reservation->user_id);
//            $reservations[$session->name][Carbon::parse($session->date)->format('d/m/Y H:i')][] = [
//                'id' => $reservation->id,
//                'user' => $user,
//                'row' => $reservation->row,
//                'column' => $reservation->column,
//            ];
//        }
//
//        return view('admin.reservations', compact('reservations'));
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
     * @param  ProcessSecondStepReservationRequest  $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function store(StoreEventRequest $request)
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
     * @return Application|Factory|View|RedirectResponse
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
     * @return Application|Factory|View|RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $this->authorize('edit', $event);

        $validated = $request->validated();

        $event->update([
            'event_type_id' => $validated['event_type'],
            'date' => Carbon::parse($validated['event_datetime'])->toDateString(),
            'time' => Carbon::parse($validated['event_datetime'])->toTimeString(),
        ]);

        if (auth()->user()->id !== $event->user_id) {
            return redirect()->route('event.index')->with('message', __('Event updated'));
        } else {
            return back()->with('message', __('Event updated'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Event $event
     * @return RedirectResponse
     */
    public function destroy(Event $event): RedirectResponse
    {
        $this->authorize('destroy', $event);

        $event->delete();

        return back()->with('message', __('Event deleted'));
    }
}
