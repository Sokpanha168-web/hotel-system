<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mini-Mart - Home</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; color: #2c3e50; }

        header {
            background-color: #2c3e50;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header .logo {
            color: #fff;
            font-size: 1.5rem;
            font-weight: bold;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
        }

        nav a:hover {
            color: #e74c3c;
        }

        .hero {
            background-color: #34495e;
            color: #fff;
            text-align: center;
            padding: 80px 20px;
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .hero p {
            color: #ecf0f1;
            margin-bottom: 25px;
        }

        .btn {
            background-color: #e74c3c;
            color: #fff;
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
        }

        .btn:hover {
            background-color: #c0392b;
        }

        .features {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 50px 20px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .feature-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            width: 260px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }

        .feature-card h3 {
            margin: 10px 0;
            color: #2c3e50;
        }

        footer {
            background-color: #2c3e50;
            color: #ecf0f1;
            text-align: center;
            padding: 20px;
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">Mini-Mart</div>
        <nav>
            <a href="#">Home</a>
            <a href="#">About</a>
            <a href="#">Products</a>
            <a href="#">Contact</a>
        </nav>
    </header>

    <section class="hero">
        <h1>Welcome to Mini-Mart</h1>
        <p>Quality products, right in your neighborhood.</p>
        <a href="#" class="btn">Shop Now</a>
    </section>

    <section class="features">
        <div class="feature-card">
            <h3>Fresh Products</h3>
            <p>We stock only the freshest items every day.</p>
        </div>
        <div class="feature-card">
            <h3>Affordable Prices</h3>
            <p>Great quality without breaking your budget.</p>
        </div>
        <div class="feature-card">
            <h3>Fast Service</h3>
            <p>Quick and friendly checkout, every time.</p>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 Mini-Mart. All rights reserved.</p>
    </footer>

</body>
</html>