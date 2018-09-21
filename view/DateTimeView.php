<?php
namespace view;

class DateTimeView {
    /**
     * Return current time as html.
     *
     * @return string
     */
    public function show(): string {
        $dayOfTheWeek = date('l');
        $dayOfMonth = date('d');
        $monthAsText = date('F');
        $year = date('Y');
        $time = date('H:i:s');

        return "<p>${dayOfTheWeek}, the ${dayOfMonth}th of ${monthAsText} ${year}, The time is ${time}</p>";
    }
}
