<?php namespace Bonoize;

class Notification
{
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
