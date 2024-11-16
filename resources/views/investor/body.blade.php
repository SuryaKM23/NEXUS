<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investor Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        .nav-link {
    text-decoration: none;
    color: black;
    font-weight: 500;
  }

        header {
            background: linear-gradient(to right, #007bff, #0056b3);
            color: white;
            text-align: center;
            padding: 100px 0;
        }

        header h1 {
            font-size: 3.5rem;
            animation: fadeIn 2s ease-out;
        }

        header p {
            font-size: 1.2rem;
            margin: 20px 0 40px;
            animation: fadeIn 2s ease-out 0.5s;
        }

        header a {
            background: white;
            color: #007bff;
            padding: 12px 30px;
            border-radius: 50px;
            text-transform: uppercase;
            font-weight: bold;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        header a:hover {
            transform: scale(1.1);
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #about {
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
        }

        #opportunities .card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        #opportunities .card:hover {
            transform: translateY(-10px);
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.2);
        }

        #opportunities .card-body h5 {
            color: #007bff;
        }

        .services-icon {
            font-size: 3rem;
            color: #007bff;
            margin-bottom: 20px;
        }

        footer {
            background: #343a40;
            color: #bbb;
            padding: 5px 0;
        }

        footer a {
            color: #bbb;
            text-decoration: none;
            transition: color 0.3s;
        }

        footer a:hover {
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1><i class="bi bi-lightbulb-fill"></i> Welcome to Investor Page</h1>
            <p>Empowering innovative startups through strategic investments.</p>
            <a href="/get-crowdfunding-vc" class="btn btn-primary btn-lg"><i class="bi bi-arrow-down-circle"></i> Explore Opportunities</a>
        </div>
    </header>

    <section id="about" class="text-center py-5">
        <div class="container">
            <h2><i class="bi bi-people-fill"></i> About Us</h2>
            <p class="fs-5 mt-4">
                Startup Matchmaking bridges the gap between visionary startups and forward-thinking investors. We curate a portfolio of high-potential startups that aim to disrupt industries and create impactful solutions.
            </p>
        </div>
    </section>

    <section id="opportunities" class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-4"><i class="bi bi-cash-coin"></i> Investment Opportunities</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-cpu services-icon"></i>
                            <h5>Tech Innovation</h5>
                            <p>Revolutionary tech solutions for modern problems.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-heart-pulse services-icon"></i>
                            <h5>Healthcare Startups</h5>
                            <p>Invest in startups advancing global health.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-tree-fill services-icon"></i>
                            <h5>Green Energy</h5>
                            <p>Support eco-friendly solutions for a sustainable future.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section id="services" class="text-center py-5">
        <div class="container">
            <h2><i class="bi bi-tools"></i> Our Services</h2>
            <div class="row g-4 mt-4">
                <div class="col-md-4">
                    <i class="bi bi-bar-chart-line services-icon"></i>
                    <h5>Market Analysis</h5>
                    <p>In-depth startup evaluation to find the best investments.</p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-person-check-fill services-icon"></i>
                    <h5>Personalized Matching</h5>
                    <p>Connect with startups aligned with your vision and goals.</p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-graph-up-arrow services-icon"></i>
                    <h5>Post-Investment Support</h5>
                    <p>Comprehensive mentorship and resources to grow your portfolio.</p>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container text-center">
            <p>© 2024 Startup Matchmaking. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
