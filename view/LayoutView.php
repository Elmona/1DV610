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
    public function render($isLoggedIn, ChangeView $v, DateTimeView $dtv) {
        return '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->renderIsLoggedIn($isLoggedIn) . '

          <div class="container">
              ' . $v->response($isLoggedIn) . '
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
