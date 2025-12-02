<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NeuroCorp Resource Management System</title>
    <style>
        :root {
            --primary-neon: #0ff;
            --secondary-neon: #f0f;
            --accent-color: #0ff;
            --dark-bg: #000;
            --panel-bg: rgba(16, 16, 23, 0.8);
            --text-glow: 0 0 10px var(--primary-neon);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Rajdhani', sans-serif;
        }

        body {
            background: var(--dark-bg);
            color: #fff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                linear-gradient(45deg, transparent 48%, var(--primary-neon) 50%, transparent 52%),
                linear-gradient(-45deg, transparent 48%, var(--secondary-neon) 50%, transparent 52%);
            background-size: 60px 60px;
            opacity: 0.1;
            z-index: -1;
        }

        .container {
            width: 100%;
            max-width: 800px;
            background: var(--panel-bg);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.2);
            position: relative;
            backdrop-filter: blur(10px);
        }
		.cyber-grid {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                linear-gradient(transparent 0%, rgba(255, 0, 255, 0.05) 2%, transparent 3%),
                linear-gradient(90deg, transparent 0%, rgba(0, 255, 255, 0.05) 2%, transparent 3%);
            background-size: 50px 50px;
            animation: gridMove 20s linear infinite;
            pointer-events: none;
            z-index: -1;
     
		}
	
        .container::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, var(--primary-neon), var(--secondary-neon));
            border-radius: 16px;
            z-index: -1;
            opacity: 0.7;
            animation: borderGlow 3s infinite alternate;
        }

        @keyframes borderGlow {
            0% {
                opacity: 0.3;
            }
            100% {
                opacity: 0.7;
            }
        }

        h1 {
            color: var(--primary-neon);
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2.5em;
            text-transform: uppercase;
            letter-spacing: 3px;
            text-shadow: var(--text-glow);
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--accent-color);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9em;
            text-shadow: 0 0 5px var(--accent-color);
        }

        input {
            width: 100%;
            padding: 1rem;
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid var(--accent-color);
            color: #fff;
            border-radius: 5px;
            outline: none;
            transition: all 0.3s ease;
        }

        input:focus {
            border-color: var(--secondary-neon);
            box-shadow: 0 0 15px rgba(0, 255, 255, 0.3);
        }

        button {
            width: 100%;
            padding: 1rem;
            background: transparent;
            border: 2px solid var(--primary-neon);
            color: var(--primary-neon);
            font-size: 1.1em;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-top: 1rem;
        }

        button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(0, 255, 255, 0.2),
                transparent
            );
            transition: 0.5s;
        }

        button:hover::before {
            left: 100%;
        }

        button:hover {
            background: var(--primary-neon);
            color: var(--dark-bg);
            box-shadow: 0 0 20px var(--primary-neon);
        }

        .success, .error {
            margin-top: 1rem;
            padding: 1rem;
            border-radius: 5px;
            text-align: center;
            animation: fadeIn 0.3s ease-in;
        }

        .success {
            background: rgba(0, 255, 0, 0.1);
            border: 1px solid #0f0;
            color: #0f0;
        }

        .error {
            background: rgba(255, 0, 0, 0.1);
            border: 1px solid #f00;
            color: #f00;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .cyber-decoration {
            position: absolute;
            font-family: monospace;
            color: var(--primary-neon);
            opacity: 0.1;
            user-select: none;
            pointer-events: none;
        }

        .top-right {
            top: 20px;
            right: 20px;
        }

        .bottom-left {
            bottom: 20px;
            left: 20px;
        }
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NeuroCorp Resource Management System</title>
    <style>
        :root {
            --primary-neon: #0ff;
            --secondary-neon: #f0f;
            --accent-color: #0ff;
            --dark-bg: #000;
            --panel-bg: rgba(16, 16, 23, 0.8);
            --text-glow: 0 0 10px var(--primary-neon);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Rajdhani', sans-serif;
        }

        body {
            background: var(--dark-bg);
            color: #fff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        .cyber-grid {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                var(--dark-bg) 24px,
                transparent 1%) center,
                linear-gradient(var(--dark-bg) 24px,
                transparent 1%) center,
                var(--primary-neon);
            background-size: 25px 25px;
            opacity: 0.1;
            animation: gridMove 30s linear infinite;
            pointer-events: none;
            z-index: 0;
        }

        @keyframes gridMove {
            0% {
                transform: translate(0, 0);
            }
            100% {
                transform: translate(50px, 50px);
            }
        }

        .scan-line {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background: linear-gradient(
                transparent 0%,
                rgba(0, 255, 255, 0.2) 10%,
                rgba(0, 255, 255, 0.2) 90%,
                transparent 100%
            );
            opacity: 0.1;
            pointer-events: none;
            animation: scanline 8s linear infinite;
            z-index: 1;
        }

        @keyframes scanline {
            0% {
                transform: translateY(-100%);
            }
            100% {
                transform: translateY(100vh);
            }
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                linear-gradient(45deg, transparent 48%, var(--primary-neon) 50%, transparent 52%),
                linear-gradient(-45deg, transparent 48%, var(--secondary-neon) 50%, transparent 52%);
            background-size: 60px 60px;
            opacity: 0.1;
            z-index: -1;
        }

        .container {
            width: 100%;
            max-width: 800px;
            background: var(--panel-bg);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.2);
            position: relative;
            backdrop-filter: blur(10px);
            z-index: 2;
        }
		}
		.cyber-grid {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                linear-gradient(transparent 0%, rgba(255, 0, 255, 0.05) 2%, transparent 3%),
                linear-gradient(90deg, transparent 0%, rgba(0, 255, 255, 0.05) 2%, transparent 3%);
            background-size: 50px 50px;
            animation: gridMove 20s linear infinite;
            pointer-events: none;
            z-index: -1;
     
		}
	
        .container::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, var(--primary-neon), var(--secondary-neon));
            border-radius: 16px;
            z-index: -1;
            opacity: 0.7;
            animation: borderGlow 3s infinite alternate;
        }

        @keyframes borderGlow {
            0% {
                opacity: 0.3;
            }
            100% {
                opacity: 0.7;
            }
        }

        h1 {
            color: var(--primary-neon);
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2.5em;
            text-transform: uppercase;
            letter-spacing: 3px;
            text-shadow: var(--text-glow);
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--accent-color);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9em;
            text-shadow: 0 0 5px var(--accent-color);
        }

        input {
            width: 100%;
            padding: 1rem;
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid var(--accent-color);
            color: #fff;
            border-radius: 5px;
            outline: none;
            transition: all 0.3s ease;
        }

        input:focus {
            border-color: var(--secondary-neon);
            box-shadow: 0 0 15px rgba(0, 255, 255, 0.3);
        }

        button {
            width: 100%;
            padding: 1rem;
            background: transparent;
            border: 2px solid var(--primary-neon);
            color: var(--primary-neon);
            font-size: 1.1em;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-top: 1rem;
        }

        button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(0, 255, 255, 0.2),
                transparent
            );
            transition: 0.5s;
        }

        button:hover::before {
            left: 100%;
        }

        button:hover {
            background: var(--primary-neon);
            color: var(--dark-bg);
            box-shadow: 0 0 20px var(--primary-neon);
        }

        .success, .error {
            margin-top: 1rem;
            padding: 1rem;
            border-radius: 5px;
            text-align: center;
            animation: fadeIn 0.3s ease-in;
        }

        .success {
            background: rgba(0, 255, 0, 0.1);
            border: 1px solid #0f0;
            color: #0f0;
        }

        .error {
            background: rgba(255, 0, 0, 0.1);
            border: 1px solid #f00;
            color: #f00;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .cyber-decoration {
            position: absolute;
            font-family: monospace;
            color: var(--primary-neon);
            opacity: 0.1;
            user-select: none;
            pointer-events: none;
        }

        .top-right {
            top: 20px;
            right: 20px;
        }

        .bottom-left {
            bottom: 20px;
            left: 20px;
        }



    </style>
</head>
<body>
    <div class="cyber-grid"></div>
    <div class="scan-line"></div>
    
    <div class="container">
     
        <h1>Resource Integration Protocol</h1>
        <div class="cyber-decoration top-right">[SYS.INIT]</div>
        <div class="cyber-decoration bottom-left">[DATA.STREAM]</div>
        
        <form action="insertr.php" method="POST">
            <div class="form-group">
                <label for="course_code">Course Identifier</label>
                <input type="text" id="course_code" name="course_code" required placeholder="Enter course identification code">
            </div>

            <div class="form-group">
                <label for="video_link">Video Resource Link</label>
                <input type="text" id="video_link" name="video_link" required placeholder="Input video data stream URL">
            </div>

            <div class="form-group">
                <label for="book_link">Book Resource Link</label>
                <input type="text" id="book_link" name="book_link" required placeholder="Input document repository URL">
            </div>

            <div class="form-group">
                <label for="slide_link">Slide Resource Link</label>
                <input type="text" id="slide_link" name="slide_link" required placeholder="Input presentation data URL">
            </div>

            <div class="form-group">
                <label for="notes_link">Notes Resource Link</label>
                <input type="text" id="notes_link" name="notes_link" required placeholder="Input supplementary data URL">
            </div>

            <div class="form-group">
                <label for="number">Sequence Number</label>
                <input type="number" id="number" name="number" required placeholder="Enter sequence identifier">
            </div>

            <button type="submit">Initialize Data Upload</button>
        </form>

        <div class="message-container">
            <?php if(isset($message)): ?>
                <p class="<?php echo $status; ?>"><?php echo $message; ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>