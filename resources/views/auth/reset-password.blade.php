<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password – SchoolMapr</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --sm-blue: #003b95;
            --sm-blue-hover: #002c70;
            --sm-bg: #f5f7fb;
            --sm-border: #e5e7eb;
            --sm-text: #1f2937;
        }
        
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; margin: 0; padding: 0; }
        body { min-height: 100vh; background: var(--sm-bg); display: flex; flex-direction: column; }

        /* HEADER */
        .sm-header {
            background: #0f2d59;
            padding: 16px 24px;
            display: flex;
            align-items: center;
        }
        .sm-brand {
            color: #fff;
            font-size: 22px;
            font-weight: 800;
            text-decoration: none;
        }
        .sm-brand span { color: #febb02; }
        .sm-brand:hover { color: #fff; }

        /* MAIN CONTAINER */
        .auth-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }
        
        .auth-card {
            background: #fff;
            width: 100%;
            max-width: 420px;
            border-radius: 8px;
            border: 1px solid var(--sm-border);
            box-shadow: 0 4px 16px rgba(0,0,0,0.04);
            padding: 32px;
        }

        .auth-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--sm-text);
            margin-bottom: 8px;
        }
        .auth-sub {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 24px;
            line-height: 1.5;
        }

        /* ALERTS */
        .alert-error {
            background: #fef2f2; border: 1px solid #fecaca; color: #dc2626;
            border-radius: 6px; padding: 12px; font-size: 13px;
            margin-bottom: 20px; display: flex; align-items: center; gap: 8px;
        }

        /* FORM */
        .form-group { margin-bottom: 20px; }
        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: var(--sm-text);
            display: block;
            margin-bottom: 6px;
        }
        .form-input {
            width: 100%;
            border: 1px solid #6b7280;
            border-radius: 6px;
            padding: 12px;
            font-size: 15px;
            outline: none;
            color: var(--sm-text);
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-input:focus {
            border-color: var(--sm-blue);
            box-shadow: 0 0 0 3px rgba(0, 59, 149, 0.1);
        }

        /* BUTTON */
        .btn-auth {
            width: 100%;
            background: var(--sm-blue);
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 14px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 8px;
        }
        .btn-auth:hover { background: var(--sm-blue-hover); }

    </style>
</head>
<body>

    <header class="sm-header">
        <a href="/" class="sm-brand">School<span>Mate</span></a>
    </header>

    <div class="auth-wrapper">
        <div class="auth-card">
            <h1 class="auth-title">Create new password</h1>
            <p class="auth-sub">Please enter your email and choose a new, secure password for your account.</p>

            @if($errors->any())
            <div class="alert-error">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="/reset-password">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label class="form-label">Email address</label>
                    <input type="email" name="email" class="form-input" placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
                </div>
                
                <div class="form-group">
                    <label class="form-label">New password</label>
                    <input type="password" name="password" class="form-input" placeholder="Minimum 6 characters" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm new password</label>
                    <input type="password" name="password_confirmation" class="form-input" placeholder="Repeat new password" required>
                </div>

                <button type="submit" class="btn-auth">Reset password</button>
            </form>
        </div>
    </div>

</body>
</html>