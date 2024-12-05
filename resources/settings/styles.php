<?php
    namespace PET\settings;

    class styles{

    static function getThemeList()
    {
        return ['beige', 'dracula', 'solarized', 'solarized_dark', 
                'monokai', 'gray', 'red', 'green', 
                'brown', 'blue', 'dark', 'christmas', 
                'halloween', 'pastel_orange', 'warm_red', 'dragon'];
    }

    static function getTheme($theme)
    {
        switch ($theme) {
            case 'warm_red':
            return "--background-color: #ffe5e5;
                    --header-color: #c0392b;
                    --form-bg-color: #ffcccc;
                    --form-border-color: #e74c3c;
                    --button-color: #e74c3c;
                    --button-hover-color: #c0392b;
                    --text-color: #2c3e50;
                    --input-bg-color: #ff9999;
                    --input-border-color: #e74c3c;
                    --link-color: #e74c3c;
                    --link-color-visited: #c0392b;
                    --error-color: #a93226;
                    --error-color-background: #f5b7b1;
                    --success-color: #27ae60;
                    --success-color-background: #d5f5e3;
                    --table-row-hover-color: #efb7b7;
                    --button-text-color: #ffffff;

                ";
            case 'dragon': //With Derg's seal of approval
            return "--background-color: #2a3a27;
                    --header-color: #354d30;
                    --form-bg-color: #3e5734;
                    --form-border-color: #5c7948;
                    --button-color: #789f63;
                    --button-hover-color: #607d4e;
                    --text-color: #e5e9d9;
                    --input-bg-color: #2f4028;
                    --input-border-color: #6b8653;
                    --link-color: #b2c78e;
                    --link-color-visited: #97a977;
                    --error-color: #e09163;
                    --error-color-background: #553d2b;
                    --success-color: #9aba72;
                    --success-color-background: #465b38;
                    --table-row-hover-color: #4b6434;
                    --button-text-color: #f0f0f0;
                    ";
            case 'pastel_orange':
            return "--background-color: #fff5e6;
                    --header-color: #f39c12;
                    --form-bg-color: #ffd9b3;
                    --form-border-color: #e67e22;
                    --button-color: #e67e22;
                    --button-hover-color: #d35400;
                    --text-color: #2c3e50;
                    --input-bg-color: #ffcc99;
                    --input-border-color: #e67e22;
                    --link-color: #e67e22;
                    --link-color-visited: #d35400;
                    --error-color: #d35400;
                    --error-color-background: #f9e79f;
                    --success-color: #27ae60;
                    --success-color-background: #d5f5e3;
                    --table-row-hover-color: #ffe6cc;
                    --list-tag-color-fixed: #a7d7a7;
                    --button-text-color: #ffffff;
                ";
            case 'halloween':
            return "--background-color: #1c1c1c;
                    --header-color: #ff6600;
                    --form-bg-color: #2e2e2e;
                    --form-border-color: #ff6600;
                    --button-color: #ff6600;
                    --button-hover-color: #cc5200;
                    --text-color: #f0f0f0;
                    --input-bg-color: #3e3e3e;
                    --input-border-color: #ff9933;
                    --link-color: #ff9933;
                    --link-color-visited: #cc5200;
                    --error-color: #ff3300;
                    --error-color-background: #ffe6cc;
                    --success-color: #33cc33;
                    --success-color-background: #d5f5e3;
                    --table-row-hover-color: #292929;
                    --button-text-color: #ffffff;
                ";
            case 'christmas':
            return "--background-color: #f4faff;
                    --header-color: #e63946;
                    --form-bg-color: #ffffff;
                    --form-border-color: #2a9d8f;
                    --button-color: #2a9d8f;
                    --button-hover-color: #1e7066;
                    --text-color: #264653;
                    --input-bg-color: #e8f7f5;
                    --input-border-color: #2a9d8f;
                    --link-color: #e63946;
                    --link-color-visited: #a82836;
                    --error-color: #e63946;
                    --error-color-background: #fbd5d7;
                    --success-color: #34a853;
                    --success-color-background: #daf7dc;
                    --table-row-hover-color: #ebf5f4;
                    --button-text-color: #ffffff;
                ";
            
            case 'dark':
            return "--background-color: #121212;
                    --header-color: #1e1e1e;
                    --form-bg-color: #1a1a1a;
                    --form-border-color: #333333;
                    --button-color: #3a3a3a;
                    --button-hover-color: #505050;
                    --text-color: #e0e0e0;
                    --input-bg-color: #1f1f1f;
                    --input-border-color: #444444;
                    --link-color: #80aaff;
                    --link-color-visited: #607dce;
                    --error-color: #ff4c4c;
                    --error-color-background: #661414;
                    --success-color: #4caf50;
                    --success-color-background: #1b4025;
                    --table-row-hover-color: #2a2a2a;
                    --button-text-color: #ffffff;
                ";
            case 'blue':
            return "--background-color: #f0f4f9;
                    --header-color: #e4ebf1;
                    --form-bg-color: #ffffff;
                    --form-border-color: #d1d9e0;
                    --button-color: #6b8ead;
                    --button-hover-color: #5a7792;
                    --text-color: #404040;
                    --input-bg-color: #f9fafb;
                    --input-border-color: #bcc6d2;
                    --link-color: #2a73c3;
                    --link-color-visited: #1c4a88;
                    --error-color: #d9534f;
                    --error-color-background: #fbeae9;
                    --success-color: #5cb85c;
                    --success-color-background: #eaf4e6;
                    --table-row-hover-color: #e8f1fb;
                    --button-text-color: #ffffff;
                ";

            case 'brown':
            return "--background-color: #f4efe6;
                    --header-color: #e8dacc;
                    --form-bg-color: #faf4ee;
                    --form-border-color: #c9b8a8;
                    --button-color: #b48962;
                    --button-hover-color: #986d4b;
                    --text-color: #4a3f35;
                    --input-bg-color: #f6f0e9;
                    --input-border-color: #b3a595;
                    --link-color: #b57f4c;
                    --link-color-visited: #8c5d34;
                    --error-color: #b35b5b;
                    --error-color-background: #f5e3e3;
                    --success-color: #7a9d7a;
                    --success-color-background: #edf3eb;
                    --table-row-hover-color: #f7f0e6;
                    --button-text-color: #ffffff;
                ";

            case 'green':
            return "--background-color: #eaf4e6;
                    --header-color: #d8ecd5;
                    --form-bg-color: #ffffff;
                    --form-border-color: #b4d4b0;
                    --button-color: #66a066;
                    --button-hover-color: #4e8b4e;
                    --text-color: #3f4e3f;
                    --input-bg-color: #f5f9f4;
                    --input-border-color: #9ab89a;
                    --link-color: #4d9e4d;
                    --link-color-visited: #3a723a;--error-color: #a94442;
                    --error-color-background: #f8e8e6;
                    --success-color: #4d9e4d;
                    --success-color-background: #eaf4e6;
                    --table-row-hover-color: #e0efe0;
                    --button-text-color: #ffffff;
                ";

            case 'red':
            return "--background-color: #fbeae9;
                    --header-color: #f5d7d5;
                    --form-bg-color: #ffffff;
                    --form-border-color: #e1a7a7;
                    --button-color: #cc4c4c;
                    --button-hover-color: #b23939;
                    --text-color: #4e3f3f;
                    --input-bg-color: #f9f2f2;
                    --input-border-color: #d19292;
                    --link-color: #d94a4a;
                    --link-color-visited: #a33535;
                    --error-color: #d94a4a;
                    --error-color-background: #fbeae9;
                    --success-color: #a94442;
                    --success-color-background: #f8e8e6;
                    --table-row-hover-color: #fce7e6;
                    --button-text-color: #ffffff;
                ";

            case 'gray':
            return "--background-color: #f5f5f5;
                    --header-color: #eaeaea;
                    --form-bg-color: #ffffff;
                    --form-border-color: #cccccc;
                    --button-color: #7a7a7a;
                    --button-hover-color: #5f5f5f;
                    --text-color: #3f3f3f;
                    --input-bg-color: #f8f8f8;
                    --input-border-color: #b0b0b0;
                    --link-color: #5f5f5f;
                    --link-color-visited: #3f3f3f;
                    --error-color: #7a4f4f;
                    --error-color-background: #f1e9e9;
                    --success-color: #4f7a4f;
                    --success-color-background: #e9f1e9;
                    --table-row-hover-color: #eaeaea;
                    --button-text-color: #2c2c2c;
                ";

            case 'monokai':
            return "--background-color: #272822;
                    --header-color: #383830;
                    --form-bg-color: #3e3d32;
                    --form-border-color: #75715e;
                    --button-color: #80b418;
                    --button-hover-color: #66d917;
                    --text-color: #f8f8f2;
                    --input-bg-color: #49483e;
                    --input-border-color: #a59f85;
                    --link-color: #a6e22e;
                    --link-color-visited: #66d917;
                    --error-color: #f92672;
                    --error-color-background: #3e2a37;
                    --success-color: #a6e22e;
                    --success-color-background: #2a3e2f;
                    --table-row-hover-color: #49483e;
                    --button-text-color: #f8f8f2;
                ";

            case 'solarized':
            return "--background-color: #fdf6e3;
                    --header-color: #eee8d5;
                    --form-bg-color: #ffffff;
                    --form-border-color: #93a1a1;
                    --button-color: #268bd2;
                    --button-hover-color: #2067a2;
                    --text-color: #556b73;
                    --input-bg-color: #f5efdc;
                    --input-border-color: #839496;
                    --link-color: #268bd2;
                    --link-color-visited: #1c6399;
                    --error-color: #dc322f;
                    --error-color-background: #fdf0ef;
                    --success-color: #859900;
                    --success-color-background: #f4f8e8;
                    --table-row-hover-color: #f5efd7;
                    --button-text-color: #fdf6e3;
                ";

            case 'solarized_dark':
            return "--background-color: #002b36;
                    --header-color: #073642;
                    --form-bg-color: #002b36;
                    --form-border-color: #586e75;
                    --button-color: #1b6193;
                    --button-hover-color: #206080;
                    --text-color: #839496;
                    --input-bg-color: #073642;
                    --input-border-color: #93a1a1;
                    --link-color: #268bd2;
                    --link-color-visited: #2aa198;
                    --error-color: #dc322f;
                    --error-color-background: #3c2120;
                    --success-color: #859900;
                    --success-color-background: #2d4023;
                    --table-row-hover-color: #073642;
                    --button-text-color: #fdf6e3;
                ";

            case 'dracula':
            return "--background-color: #282a36;
                    --header-color: #44475a;
                    --form-bg-color: #6272a4;
                    --form-border-color: #bd93f9;
                    --button-color: #50fa7b;
                    --button-hover-color: #45d56c;
                    --text-color: #f8f8f2;
                    --input-bg-color: #373b50;
                    --input-border-color: #6272a4;
                    --link-color: #8be9fd;
                    --link-color-visited: #50b6d2;
                    --error-color: #ff79c6;
                    --error-color-background: #3b2835;
                    --success-color: #50fa7b;
                    --success-color-background: #283b28;
                    --table-row-hover-color: #383a4a;
                    --button-text-color: #f8f8f2;
                ";

            case 'beige':
            default:
            return "--background-color: #fdf6f0;
                    --header-color: #f7e4d7;
                    --form-bg-color: #ffffff;
                    --form-border-color: #e0d5c9;
                    --button-color: #f4a261;
                    --button-hover-color: #e68c4d;
                    --text-color: #5c5c5c;
                    --input-bg-color: #f9f4f0;
                    --input-border-color: #cfc3b6;
                    --link-color: #a57b50;
                    --link-color-visited: #715636;
                    --error-color: #a94442;
                    --error-color-background: #f8e8e6;
                    --success-color: #5d8a5d;
                    --success-color-background: #eaf1e9;
                    --table-row-hover-color: #f8ede7;
                    --button-text-color: #6a4e23;
                ";
        }
    }
}