<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Account</title>
    <!-- Add SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #e8ecef 0%, #d1d8e0 100%);
            min-height: 100vh;
            padding: 2rem;
            opacity: 0;
            animation: pageLoad 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        /* Page Transition Styles */
        .page-transition-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #e8ecef 0%, #d1d8e0 100%);
            z-index: 9999;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .page-transition-overlay.active {
            opacity: 1;
            pointer-events: all;
        }

        @keyframes pageLoad {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            opacity: 0;
            transform: translateY(20px);
            animation: containerFadeIn 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            animation-delay: 0.2s;
        }

        @keyframes containerFadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            text-align: center;
            margin-bottom: 2rem;
            color: #2c3e50;
        }

        .header h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
            opacity: 0;
            transform: translateY(-20px);
            animation: headerFadeIn 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            animation-delay: 0.4s;
        }

        .header p {
            opacity: 0;
            transform: translateY(-15px);
            animation: headerFadeIn 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            animation-delay: 0.6s;
        }

        @keyframes headerFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 20px rgba(0,0,0,0.08);
            opacity: 0;
            transform: translateY(30px);
            animation: formCardFadeIn 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            animation-delay: 0.8s;
        }

        @keyframes formCardFadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-group {
            margin-bottom: 1.5rem;
            opacity: 0;
            transform: translateX(-20px);
            animation: formGroupFadeIn 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .form-group:nth-child(1) { animation-delay: 1.0s; }
        .form-group:nth-child(2) { animation-delay: 1.2s; }
        .form-group:nth-child(3) { animation-delay: 1.4s; }
        .form-group:nth-child(4) { animation-delay: 1.6s; }
        .form-group:nth-child(5) { animation-delay: 1.8s; }

        @keyframes formGroupFadeIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            70% {
                opacity: 0.7;
                transform: translateX(5px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #2c3e50;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #e1e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
            transform: translateY(-2px);
        }

        .submit-btn {
            background-color: #4CAF50;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            opacity: 0;
            transform: translateY(20px);
            animation: buttonFadeIn 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            animation-delay: 2s;
        }

        @keyframes buttonFadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .submit-btn:hover {
            background-color: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .back-btn {
            display: inline-block;
            margin-top: 1rem;
            color: #64748b;
            text-decoration: none;
            font-size: 0.9rem;
            opacity: 0;
            transform: translateY(20px);
            animation: buttonFadeIn 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            animation-delay: 2.2s;
        }

        .back-btn:hover {
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <!-- Add overlay div for transitions -->
    <div class="page-transition-overlay"></div>

    <div class="container">
        <div class="header">
            <h1>Add New Account</h1>
            <p>Fill in the details below</p>
        </div>

        <div class="form-card">
            <form id="addAccountForm" action="{{ route('pengurus.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama_lengkap">Nama</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" required>
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" id="alamat" name="alamat" required>
                </div>

                <div class="form-group">
                    <label for="nomor_telepon">No HP</label>
                    <input type="tel" id="nomor_telepon" name="nomor_telepon" required>
                </div>

                <button type="submit" class="submit-btn">Submit</button>
            </form>
            <a href="{{ route('pengurus') }}" class="back-btn">← Back to Account Management</a>
        </div>
    </div>

    <!-- Add SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Add page transition handling
        document.addEventListener('DOMContentLoaded', function() {
            // Handle all link clicks for transition
            document.addEventListener('click', function(e) {
                const link = e.target.closest('a');
                if (link && !e.ctrlKey && !e.shiftKey && !e.metaKey && !e.altKey) {
                    e.preventDefault();
                    const overlay = document.querySelector('.page-transition-overlay');
                    overlay.classList.add('active');
                    
                    setTimeout(() => {
                        window.location.href = link.href;
                    }, 300);
                }
            });

            // Handle form submissions for transition
            document.getElementById('addAccountForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const form = this;
                const formData = new FormData(form);
                const overlay = document.querySelector('.page-transition-overlay');

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        overlay.classList.add('active');
                        setTimeout(() => {
                            window.location.href = '{{ route("pengurus") }}';
                        }, 300);
                    } else {
                        throw new Error(data.message || 'Error creating account');
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Error!',
                        text: error.message || 'Something went wrong',
                        icon: 'error',
                        confirmButtonColor: '#4CAF50'
                    });
                });
            });
        });
    </script>
</body>
</html> 