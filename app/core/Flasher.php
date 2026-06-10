<?php

    class Flasher {
        public static function setFlash($pesan, $tipe) {
            $_SESSION['flash'] = [
                'pesan' => $pesan,
                'tipe' => $tipe
            ];
        }

        public static function flash() {
            if( isset($_SESSION['flash']) ) {
                $pesan = $_SESSION['flash']['pesan'];
                $tipe = $_SESSION['flash']['tipe'];

                // Normalize style classes and icon mappings
                $icon = 'info-circle';
                if ($tipe == 'success') {
                    $icon = 'check-circle';
                } else if ($tipe == 'danger' || $tipe == 'error') {
                    $icon = 'exclamation-circle';
                    $tipe = 'danger';
                } else if ($tipe == 'warning') {
                    $icon = 'exclamation-triangle';
                }

                echo '
                <div class="alert alert-' . $tipe . '" id="flash-alert">
                    <div class="alert-content">
                        <i class="fas fa-' . $icon . '"></i>
                        <span>' . htmlspecialchars($pesan) . '</span>
                    </div>
                    <button type="button" class="alert-close" onclick="document.getElementById(\'flash-alert\').style.display=\'none\'">&times;</button>
                </div>
                ';
                unset($_SESSION['flash']);
            }
        }
    }
