<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Mail\ContactFormSubmitted;
use App\Models\StaticPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class ContactController extends Controller
{
    public function show(): View
    {
        $staticPage = StaticPage::query()
            ->where('slug', 'contact')
            ->where('is_active', true)
            ->first();

        return view('contact', [
            'staticPage' => $staticPage,
        ]);
    }

    public function store(ContactFormRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $recipient = config('mail.contact_to');

        if (! is_string($recipient) || $recipient === '') {
            Log::error('Contact form: MAIL_CONTACT_TO is not configured.');

            return back()
                ->withInput()
                ->withErrors(['form' => __('contact.send_failed')]);
        }

        try {
            Mail::to($recipient)->send(new ContactFormSubmitted($data));
        } catch (Throwable $e) {
            Log::error('Contact form mail failed.', [
                'exception' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['form' => __('contact.send_failed')]);
        }

        return redirect()
            ->route('contact')
            ->with('contact_success', true);
    }
}

