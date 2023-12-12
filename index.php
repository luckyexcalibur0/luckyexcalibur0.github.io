<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project: Exca</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Assistant&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS/custom.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="path/to/your/style.css">
    <style>
        /* Add your custom styles here */
        header {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: #23b464;
            color: #ecf0f1;
            padding: 10px;
            z-index: 1000;
            transition: background-color 0.3s ease-in-out;
            display: flex;
            justify-content: space-between; /* Align items horizontally */
            align-items: center; /* Center items vertically */
        }

        /* Navbar style */
        .navbar {
            display: flex;
        }

        /* Style for the navigation switch buttons */
        .nav-switch {
            cursor: pointer;
            padding: 10px;
            margin: 0 10px;
            border: none;
            background-color: transparent;
            color: #ecf0f1;
            font-size: 16px;
            outline: none;
            transition: color 0.3s ease;
        }

        .nav-switch:hover {
            color: #ffa07a; /* or any other color you prefer */
        }

        /* Main content styles */
        body {
            margin-top: 70px; /* Adjust margin-top to accommodate the fixed header */
            font-family: 'Assistant', sans-serif;
            line-height: 1.6;
            background-color: #ffffff;
            color: #333;
        }

        /* Table styles */
        .styled-table-container {
            max-height: 400px; /* Adjust the height as needed */
            overflow: auto;
        }

        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            overflow-x: auto; /* Add horizontal scroll for small screens */
        }

        .styled-table th, .styled-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .styled-table th {
            background-color: #f2f2f2;
            position: sticky;
            top: 0; /* Set the top value to 0 to make it stick at the top */
            z-index: 1; /* Set z-index to appear above content while scrolling */
        }

        /* Footer styles */
        footer {
            text-align: center;
            padding: 10px;
            background-color: #23b464;
            color: #ecf0f1;
        }

        .footer-content {
            display: flex;
            justify-content: space-around;
        }

        .footer-section {
            flex: 1;
        }

        /* Responsive styles */
        @media only screen and (max-width: 600px) {
            header {
                flex-direction: column;
                align-items: flex-start;
            }

            .navbar {
                flex-direction: column;
                align-items: center;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>

<header>
    <div id="menu">
        <a href="index.php"><img src="CSS/p/image.png" class="logo1" alt="Exca Logo"></a>
    </div>
    <h1>Project: Exca</h1>

    <!-- Navbar -->
    <nav class="navbar">
        <button class="nav-switch" onclick="loadPage('fiatConv')">Fiat Conv</button>
        <button class="nav-switch" onclick="loadPage('cryptoPrices')">Real-time Cryptocurrency Prices</button>
        <button class="nav-switch" onclick="loadPage('exchangeRates')">Exchange Rates</button>
    </nav>
</header>

<div id="content">
    <!-- This div will hold the dynamically loaded content -->
    <div id="dynamic-content" class="styled-table-container">
        <!-- Content for Fiat Conv page goes here -->
    </div>
</div>

<footer>
    <div class="footer-content">
        <div class="footer-section">
            <h2>Contact Us</h2>
            <p>Email: delossantosd262@gmail.com</p>
            <p>Phone: 0905-8531-846</p>
        </div>
        <div class="footer-section">
            <h2>Quick Links</h2>
            <ul>
                <!-- Add target="_blank" to open the link in a new tab -->
                <li><a href="https://www.facebook.com/daneiru.miyazono" target="_blank">Facebook</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h2>Follow Us</h2>
            <p>Stay connected on social media:</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2023 Exca. All rights reserved.</p>
    </div>
</footer>

<script>
    // Function to load content based on the selected page
    const loadPage = async (page) => {
        const dynamicContent = document.getElementById('dynamic-content');

        // Clear existing content
        dynamicContent.innerHTML = '';

        // Load content based on the selected page
        switch (page) {
            case 'fiatConv':
                try {
                    // Fetch data from the API
                    const response = await fetch('https://api4.binance.com/api/v3/ticker/24hr');
                    const data = await response.json();

                    // Organize the data into a table with styling
                    const table = document.createElement('table');
                    table.classList.add('styled-table'); // Add the styled-table class

                    // Create table header
                    const thead = document.createElement('thead');
                    thead.innerHTML = `
                        <tr>
                            <th>Symbol</th>
                            <th>Price Change</th>
                            <th>Price Change Percent</th>
                            <th>"Loss/Gain" Converted to PHP</th>
                        </tr>
                    `;
                    table.appendChild(thead);

                    // Create table body
                    const tbody = document.createElement('tbody');
                    data.forEach(item => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.symbol}</td>
                            <td>${item.priceChange}</td>
                            <td>${item.priceChangePercent}</td>
                            <td>${convertToPhilippinePeso(parseFloat(item.priceChangePercent))} PHP</td>
                        `;
                        tbody.appendChild(row);
                    });
                    table.appendChild(tbody);

                    dynamicContent.appendChild(table);
                } catch (error) {
                    console.error('Error fetching and organizing data:', error);
                }
                break;
            case 'cryptoPrices':
                try {
                    // Fetch data from the cryptocurrency prices API
                    const response = await fetch('https://api.coincap.io/v2/assets');
                    const { data } = await response.json();

                    // Organize the data into a table with styling
                    const table = document.createElement('table');
                    table.classList.add('styled-table'); // Add the styled-table class

                    // Create table header
                    const thead = document.createElement('thead');
                    thead.innerHTML = `
                        <tr>
                            <th>Name</th>
                            <th>Symbol</th>
                            <th>Price (USD)</th>
                            <th>Price (PHP)</th>
                        </tr>
                    `;
                    table.appendChild(thead);

                    // Create table body
                    const tbody = document.createElement('tbody');
                    data.forEach(item => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.name}</td>
                            <td>${item.symbol}</td>
                            <td>${item.priceUsd}</td>
                            <td>${convertToPhilippinePesoCrypto(parseFloat(item.priceUsd))} PHP</td>
                        `;
                        tbody.appendChild(row);
                    });
                    table.appendChild(tbody);

                    dynamicContent.appendChild(table);
                } catch (error) {
                    console.error('Error fetching and organizing data:', error);
                }
                break;
            case 'exchangeRates':
                try {
                    // Fetch data from the exchange rates API
                    const response = await fetch('https://open.er-api.com/v6/latest/USD');
                    const { rates } = await response.json();

                    // Organize the data into a table with styling
                    const table = document.createElement('table');
                    table.classList.add('styled-table'); // Add the styled-table class

                    // Create table header
                    const thead = document.createElement('thead');
                    thead.innerHTML = `
                        <tr>
                            <th>Currency</th>
                            <th>Exchange Rate (USD to PHP)</th>
                        </tr>
                    `;
                    table.appendChild(thead);

                    // Create table body
                    const tbody = document.createElement('tbody');
                    Object.entries(rates).forEach(([currency, rate]) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${currency}</td>
                            <td>${rate}</td>
                        `;
                        tbody.appendChild(row);
                    });
                    table.appendChild(tbody);

                    dynamicContent.appendChild(table);
                } catch (error) {
                    console.error('Error fetching and organizing data:', error);
                }
                break;
            default:
                break;
        }
    };

    // Function to convert price change percent to Philippine Peso
    const convertToPhilippinePeso = priceChangePercent => {
        // You can implement the conversion logic here
        // For demonstration, let's assume a simple conversion factor
        const conversionFactor = 50; // Adjust this value as needed
        const convertedValue = priceChangePercent * conversionFactor;
        return convertedValue.toFixed(2); // Round to two decimal places
    };

    // Function to convert cryptocurrency price from USD to Philippine Peso
    const convertToPhilippinePesoCrypto = priceUsd => {
        // You can implement the conversion logic here
        // For demonstration, let's assume a simple conversion factor
        const conversionFactor = 50; // Adjust this value as needed
        const convertedValue = priceUsd * conversionFactor;
        return convertedValue.toFixed(2); // Round to two decimal places
    };
</script>

</body>
</html>
