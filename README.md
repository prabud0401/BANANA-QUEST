# Banana Quest Project Structure

## Student Details
- **Full Name**: Udayasooriyan Prabudeva  
- **Email**: prabudeva.udayasooriyan@study.beds.ac.uk  
- **University**: University of Bedfordshire  
- **Registration Number**: 2431980  
- **Affiliated Institution**: SLIIT City Uni, Sri Lanka  

## Project Overview
"Banana Quest" is an interactive web-based puzzle game developed using **HTML**, **Tailwind CSS**, **CSS**, **JavaScript**, **PHP**, **MySQL**, and **AJAX** for dynamic front-end and back-end integration. Players guide a monkey through a grid of locked doors to reach a pile of bananas. Starting at Level 1 with one row and one door, players solve puzzles fetched from the **Banana API** (https://marcconrad.com/uob/banana/api.php) to unlock doors. Each level increases in complexity by adding two more rows—Level 2 has 3 doors, Level 3 has 5 doors, and so forth. Successfully solving all puzzles in a level advances the player, with the grid expanding accordingly. AJAX handles login, signup, puzzle retrieval, and game state updates, ensuring a smooth user experience. This project combines logic, design, and external API integration for a fun and challenging adventure!

## Banana API Usage
Per the assignment requirements, the **Banana API** (https://marcconrad.com/uob/banana/api.php?out=json) is utilized to source puzzles for the game. Integrated via PHP in the `banana_api.php` script, the API delivers JSON-formatted questions and solutions. The solution is stored in a PHP session, and user answers, submitted through AJAX POST requests, are validated against it. This external API enriches the gameplay with diverse puzzles, fulfilling the assignment’s objective of incorporating an external puzzle provider.


## Database Resources
- **Database Name**: `banana_quest`
- **Tables**:
    - `users`: Stores user information (e.g., username, password, email).
    - `user_history`: Tracks user actions and scores.

## Additional Materials
1. **Video Presentation**: [Banana-Quest Demo video](https://youtu.be/5e8mCmJb4QM)
2. **Project Management**: [Notion Workspace](https://www.notion.so/BANANA-QUEST-1c0460e45a4880ddb4f1d4552e9bb169?pvs=21)
3. **Design**:
    - [Figma Design](https://www.figma.com/design/33HWOg5Y8O7xeUO7vkOHFz/Banana-quest?node-id=0-1&p=f&t=cq0MQqRPZ8ZPILOv-0)
4. **Source Code**:
    - [GitHub Repository](https://github.com/prabud0401/BANANA-QUEST.git)

5. **DSA concepts**
## Key Concepts and Their Usage

| **Concept**              | **How It’s Used**                                      | **Example**                                   |
|--------------------------|-------------------------------------------------------|-----------------------------------------------|
| **High Cohesion, Low Coupling** | Frontend (UI/game) and backend (API/data) are separate, linked by AJAX. | `fetch('banana_api.php')` fetches puzzles.   |
| **Events**               | Clicks trigger actions like puzzles or level-ups.     | `canvas.addEventListener('click', ...)`      |
| **Virtual Identity**     | Sessions track users via username.                    | `$_SESSION['username']` checks login.        |
| **Interoperability**     | JSON over HTTP connects frontend, backend, and API.   | `fetch('save_game_data.php', { body: JSON })`|

6. **Evidence of Presentation**: Proof of project presentation to the tutor in Week 8.
![alt text](Appendix/Scan_20250330.png)
![alt text](<Appendix/Scan_20250330 (2).png>) 
![alt text](<Appendix/Scan_20250330 (3).png>) 
![alt text](<Appendix/Scan_20250330 (4).png>) 
