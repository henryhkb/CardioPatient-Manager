<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Korle Bu Cardio Booking') }}</title>

    {{-- Bootstrap 5 + Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
        }

        .card-soft {
            border: 0;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .06);
        }

        .card-soft {
            border: 1px solid rgba(0, 0, 0, .08);
            border-radius: 14px;
        }

        .icon-badge {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-soft:hover {
            transform: translateY(-3px);
            transition: .2s ease;
            box-shadow: 0 12px 30px rgba(0, 0, 0, .08);
        }

        .icon-badge {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-link {
            transition: 0.2s ease;
        }

        .btn-link:hover {
            transform: scale(1.2);
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-white border-bottom">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                <i class="bi bi-heart-pulse me-1 text-danger"></i> Korle Bu Cardio
            </a>

            <div class="ms-auto d-flex align-items-center gap-2">

                <a class="btn btn-outline-dark btn-sm" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>

                <a class="btn btn-outline-dark btn-sm" href="{{ route('clinics.index') }}">
                    <i class="bi bi-hospital"></i> Clinics
                </a>

                <a class="btn btn-outline-dark btn-sm" href="{{ route('procedures.index') }}">
                    <i class="bi bi-clipboard2-pulse"></i> Procedures
                </a>

                <a class="btn btn-outline-primary btn-sm" href="{{ route('bookings.create') }}">
                    <i class="bi bi-calendar-plus"></i> New Booking
                </a>

                <a class="btn btn-outline-secondary btn-sm" href="{{ route('reminders.dashboard') }}">
                    <i class="bi bi-bell"></i> Reminders
                </a>

            </div>

        </div>
    </nav>

    <main class="container py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>

</body>

</html>