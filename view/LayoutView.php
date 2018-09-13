<?php
namespace view;

class LayoutView {

    /**
     * Renders the page.
     *
     * @param boolean $isLoggedIn
     * @param LoginView $v
     * @param DateTimeView $dtv
     * @return void
     */
    public function render($isLoggedIn, LoginView $v, DateTimeView $dtv) {
        echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->renderIsLoggedIn($isLoggedIn) . '

          <div class="container">
              ' . $v->response() . '
              ' . $dtv->show() . '
          </div>
         </body>
      </html>
    ';
    }

    /**
     * Returns LoggedIn as html
     *
     * @param boolean $isLoggedIn
     * @return string
     */
    private function renderIsLoggedIn($isLoggedIn) {
        if ($isLoggedIn) {
            return '<h2>Logged in</h2>';
        } else {
            return '<h2>Not logged in</h2>';
        }
    }
}
