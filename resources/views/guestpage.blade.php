<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Research Repository - Guest Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            text-align: center;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        header {
            background: #004080;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .search-bar {
            margin: 20px 0;
        }
        input[type="text"] {
            width: 60%;
            padding: 10px;
            font-size: 16px;
        }
        .project-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .project-card {
            background: #fff;
            padding: 15px;
            margin: 10px;
            width: 300px;
            box-shadow: 0px 0px 5px rgba(0,0,0,0.2);
            border-radius: 5px;
            text-align: left;
        }
        .btn {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 12px;
            background: #004080;
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
        }
        .btn.disabled {
            background: #ccc;
        }
    </style>
</head>
<body>

<header>
    <h1>Welcome to the Research Repository</h1>
    <p>Browse academic research projects</p>
</header>

<div class="container">
    <!-- Search Bar -->
    <div class="search-bar">
        <input type="text" placeholder="Search projects by title, author, or keywords...">
    </div>

    <!-- Project Listings -->
    <div class="project-list">
        <div class="project-card">
            <h3>AI-Based Smart Irrigation System</h3>
            <p><strong>Author:</strong> John Doe</p>
            <p><strong>Supervisor:</strong> Dr. Smith</p>
            <p><strong>Year:</strong> 2024</p>
            <a href="#" class="btn disabled">Login to View</a>
        </div>

        <div class="project-card">
            <h3>Blockchain for Secure Voting</h3>
            <p><strong>Author:</strong> Jane Doe</p>
            <p><strong>Supervisor:</strong> Prof. Brown</p>
            <p><strong>Year:</strong> 2023</p>
            <a href="#" class="btn disabled">Login to View</a>
        </div>

        <div class="project-card">
            <h3>Machine Learning in Healthcare</h3>
            <p><strong>Author:</strong> Alice Smith</p>
            <p><strong>Supervisor:</strong> Dr. Johnson</p>
            <p><strong>Year:</strong> 2022</p>
            <a href="#" class="btn disabled">Login to View</a>
        </div>
    </div>

    <p><a href="login.html" class="btn">Login for Full Access</a></p>
</div>

</body>
</html>
