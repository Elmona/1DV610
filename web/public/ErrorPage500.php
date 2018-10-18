<?php

class ErrorPage500 {
    public function returnHTML() {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <title>Error 500</title>
        </head>
        <body>
            <h1>Error 500</h1>
            <p>I am really sorry but something terrible happened that is my fault.</p>
        </body>
        </html>
        ";
    }
}
