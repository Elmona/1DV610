<?php
namespace view;

class DateTimeView {
    /**
     * Return current time as html.
     *
     * @return string
     */
    public function show(): string {
        return '<p>' . date('Y-m-d H:i:s') . '</p>';
    }
}
