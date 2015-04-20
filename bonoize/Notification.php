<?php namespace Bonoize;

class Notification
{
    /**
     * Show notification
     *
     * @param  string $context
     *
     * @return \Illuminate\View\Factory
     */
    public function show($context = 'message')
    {
        if (!session($context)) {
            return;
        }

        return view('components.notification', [
            $context => session($context),
            'status' => session('status'),
        ]);
    }
}
