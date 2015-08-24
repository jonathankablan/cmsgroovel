<!DOCTYPE html>
<html lang="fr-FR">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Reset password</h2>
 
        <div>
            To reset your password click under the link below: 
            <p>
                {{ url('remind/reset'.'?_token='.$token) }}
            </p>
        </div>
    </body>
</html>