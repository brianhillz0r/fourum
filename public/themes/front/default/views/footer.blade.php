            <footer>
                <hr>
                <ul class="small-nav">
                    <li><a href="<?= url('admin') ?>">Admin</a></li>

                    @if (Auth::check())
                    <li><a href="<?= url('auth/logout') ?>">Logout</a></li>
                    @else
                    <li><a href="<?= url('auth/login') ?>">Login</a></li>
                    @endif
                </ul>
            </footer>
        </div>
        <script type="text/javascript" src="{{ theme()->js('InlineEditor.js') }}"></script>
    </body>
</html>
