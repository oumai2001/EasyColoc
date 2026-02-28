<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation à rejoindre une colocation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #3b82f6;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9fafb;
            padding: 30px;
            border: 1px solid #e5e7eb;
            border-radius: 0 0 5px 5px;
        }
        .button {
            display: inline-block;
            background-color: #3b82f6;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .button:hover {
            background-color: #2563eb;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>EasyColoc</h1>
        </div>
        
        <div class="content">
            <h2>Bonjour !</h2>
            
            <p>
                <strong>{{ $invitation->inviter->name }}</strong> vous invite à rejoindre 
                la colocation <strong>{{ $invitation->colocation->name }}</strong> sur EasyColoc.
            </p>
            
            <p>
                EasyColoc est une application qui vous aide à gérer les dépenses de votre colocation 
                simplement et efficacement.
            </p>
            
            <div style="text-align: center;">
                <a href="{{ route('invitations.accept', $invitation->token) }}" class="button">
                    Accepter l'invitation
                </a>
            </div>
            
            <p>
                Si vous ne souhaitez pas rejoindre cette colocation, vous pouvez 
                <a href="{{ route('invitations.decline', $invitation->token) }}">refuser l'invitation</a>.
            </p>
            
            <p>
                <small>Cette invitation expire le {{ $invitation->expires_at->format('d/m/Y à H:i') }}.</small>
            </p>
            
            <p>
                Si vous n'avez pas de compte EasyColoc, vous devrez en créer un 
                avant d'accepter l'invitation. Vous serez automatiquement redirigé.
            </p>
        </div>
        
        <div class="footer">
            <p>
                Cet email a été envoyé automatiquement, merci de ne pas y répondre.<br>
                &copy; {{ date('Y') }} EasyColoc. Tous droits réservés.
            </p>
        </div>
    </div>
</body>
</html>