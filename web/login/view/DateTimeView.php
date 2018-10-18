<?php
namespace view;

class DateTimeView {
    /**
     * Return current time as html.
     *
     * @return string
     */
    public function show(): string {
        $currentTime = getDate();
        $mday = $currentTime['mday'];

        $dayOfTheWeek = date('l');
        $monthAsText = date('F');
        $year = date('Y');
        $time = date('H:i:s');

        return "<p>${dayOfTheWeek}, the " . $this->ordinal($mday) . " of ${monthAsText} ${year}, The time is ${time}</p>";
    }

    // Special php hack! ty for the snippet Martin Lindahl.
    private function ordinal($number): string {
        $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
        if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
            return $number . 'th';
        } else {
            return $number . $ends[$number % 10];
        }
    }
}
