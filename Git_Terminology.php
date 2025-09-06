<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Git Terminology</title>
    <style> /* Note: I used AI to come up with the CSS to make this look better*/
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
            background-color: #f9f9f9;
        }
        h1, h2 {
            color: #333;
        }
        pre {
            background: #222;
            color: #0f0;
            padding: 10px;
            border-radius: 5px;
            overflow-x: auto;
            font-family: Consolas, monospace;
        }

        .term {
            margin-bottom: 20px;
        }
    </style>

</head>
<body>
    <h1>Git Terminology and Notes</h1>

    <div class="term">
        <h2>a. Version Control Software</h2>
        <p>Version control software is a tool that tracks changes to files over time, allowing multiple people to work on the same project without overwriting each other’s work. It keeps a history of every change so you can review, revert, or compare versions.</p>
        <pre>git version</pre>
    </div>

    <div class="term">
        <h2>b. Add</h2>
        <p>In Git, “add” iso the command that stages changes you’ve made to files so they are ready to be committed.</p>
        <pre>git add index.php</pre>
    </div>

    <div class="term">
        <h2>c. Commit</h2>
        <p>A commit is a saved snapshot of your project at a specific point in time.  It includes all staged changes and a message describing what was changed, it can also be revisited in the history.  This is essentially the “save” button.</p>
        <pre>git commit -m "Added homepage layout"</pre>
    </div>

    <div class="term">
        <h2>d. Push</h2>
        <p>This sends your local commits to your remote repository in GitHub.</p>
        <pre>git push origin main</pre>
    </div>

    <div class="term">
        <h2>e. Pull</h2>
        <p>This updates your local repository with the latest changes from your remote repository.</p>
        <pre>git pull origin main</pre>
    </div>

    <div class="term">
        <h2>f. Clone</h2>
        <p>This creates a local copy of a remote repository on your computer.  This is essentially the “copy” button.</p>
        <pre>git clone https://github.com/tdr453/WDV341.git</pre>
    </div>

    <h2>Example Git Commands</h2>
    <pre>
1. Check your Git version
git --version

2. Clone the repository to your computer
git clone https://github.com/tdr453/WDV341.git

3. Navigate into the repository folder
cd C:\xampp\htdocs\WDV341

4. Stage (add) the file for commit
git add Git_Terminology.php

5. Commit the staged changes with a message
git commit -m "Add or update Git_Terminology.php"

6. Push your commits to GitHub
git push origin main

7. Pull the latest changes from GitHub
git pull origin main

8. Check the status of your repository
git status

9. View the commit history
git log
    </pre>

</body>
</html>