<?php
    const ALIAS_REGEX = '^[a-zA-Z0-9_ ]{3,15}$';
    const PASS_REGEX = '^(?=.*[A-Za-z])(?=.*\d).{6,15}$';
    const NAME_REGEX = '^[a-zA-ZÀ-ÿ\s]{3,50}$';
    const EMAIL_REGEX = '^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,3})$';

    function toPhpRegex($pattern, $modifiers = '') {
        return '~' . $pattern . '~' . $modifiers;
    }



