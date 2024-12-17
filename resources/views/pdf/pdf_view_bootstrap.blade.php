<!DOCTYPE html>
<html>

<head>
    <title>PDF View</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            position: relative;
        }

        .back-button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px;
            cursor: pointer;
            border-radius: 12px;
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .back-button:hover {
            background-color: #45a049;
        }

        .print-button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px;
            cursor: pointer;
            border-radius: 5px;
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .print-button:hover {
            background-color: #45a049;
        }

        iframe {
            width: 100%;
            height: calc(100% - 10px);
            /* Adjust the height to accommodate the back button */
        }
    </style>
</head>

<body>
    <iframe srcdoc="{{ $pdf }}" id="pdfFrame" frameborder="0"></iframe>

    <!-- Orientation Selection -->
    <label for="orientation">Select Page Orientation:</label>
    <select id="orientation">
        <option value="portrait">Portrait</option>
        <option value="landscape">Landscape</option>
    </select>
    
    <button onclick="printIframe()" class="print-button">Print PDF</button>
    
    <script>
        function printIframe() {
            var orientation = document.getElementById('orientation').value;
            var iframe = document.getElementById('pdfFrame');
            var iframeWindow = iframe.contentWindow || iframe.contentDocument;
    
            // Apply CSS for print orientation
            var style = document.createElement('style');
            style.media = 'print';
            style.innerHTML = `@page { size: ${orientation}; }`;
    
            iframeWindow.document.head.appendChild(style);
            iframeWindow.print();
        }
    </script>
    
</body>

</html>
