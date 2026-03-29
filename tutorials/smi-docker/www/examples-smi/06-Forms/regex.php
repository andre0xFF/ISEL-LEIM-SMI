<?php
    const ALIAS_REGEX = '^[a-zA-Z0-9_ ]{3,15}$';
    const PASS_REGEX = '^(?=.*[A-Za-z])(?=.*\d).{6,15}$';

    function toPhpRegex($pattern) {
        return '~' . $pattern . '~';
    }



