const { app, BrowserWindow } = require('electron');

let mainWindow;

app.whenReady().then(() => {
    mainWindow = new BrowserWindow({
        width: 1200,
        height: 800,
        webPreferences: {
            nodeIntegration: false
        },
        icon: __dirname + '/public/storage/favicon.png' // Set the app icon
    });

    mainWindow.setMenu(null); // Remove the top menu bar
    mainWindow.loadURL('http://127.0.0.1:8000');

    // Handle new window requests (target="_blank")
    mainWindow.webContents.setWindowOpenHandler(({ url }) => {
        if (url.startsWith('http://127.0.0.1:8000/games/')) {
            const gameWindow = new BrowserWindow({
                width: 1000,
                height: 600,
                webPreferences: {
                    nodeIntegration: false
                }
            });
            gameWindow.setMenu(null); // Remove menu from new windows
            gameWindow.loadURL(url);
            return { action: 'deny' }; // Prevent default behavior
        }
        return { action: 'deny' }; // Block unknown external links
    });

    // Handle navigation inside the app
    mainWindow.webContents.on('will-navigate', (event, url) => {
        if (url.startsWith('http://127.0.0.1:8000/games/')) {
            event.preventDefault();
            const gameWindow = new BrowserWindow({
                width: 1000,
                height: 600,
                webPreferences: {
                    nodeIntegration: false
                }
            });
            gameWindow.setMenu(null); // Remove menu from new windows
            gameWindow.loadURL(url);
        }
    });
});

// Quit when all windows are closed (except on macOS)
app.on('window-all-closed', () => {
    if (process.platform !== 'darwin') {
        app.quit();
    }
});

// Handle app activation (for macOS)
app.on('activate', () => {
    if (BrowserWindow.getAllWindows().length === 0) {
        app.whenReady().then(() => {
            mainWindow = new BrowserWindow({
                width: 1200,
                height: 800,
                webPreferences: {
                    nodeIntegration: false
                }
            });
            mainWindow.setMenu(null); // Remove menu from the main window
            mainWindow.loadURL('http://127.0.0.1:8000');
        });
    }
});
