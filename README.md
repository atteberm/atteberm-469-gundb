
# GunDB

This is a web-app designed to help tabletop rpg game hosts create weapons with randomized properties for their players. 

## Deployment

### I. Install Docker and (if required) WSL

The web-app is designed to run through Docker. To run Docker, if you are on Windows, you must have WSL (Windows Subsystem Linux) installed. The steps and resources for doing so are outlined below. WARNING: this tutorial is designed for users running Windows operating system. 

1. If you are running Windows and do not have WSL installed, you will want to open a Windows Powershell prompt and enter in the command `wsl --install`

2. If you have any trouble installing WSL, help can be found on [this page](https://learn.microsoft.com/en-us/windows/wsl/install).

3. Once WSL is installed, install Docker. Visit [this page](https://docs.docker.com/engine/install/) and install the proper Desktop version of Docker for your computer. 

### II. Install web-app files

1. Download the .zip from the most recent release in the releases, seen [here](https://github.com/atteberm/atteberm-469-gundb/releases)
2. Unzip the contents into a desired directory
3. Verify that all the contents from the .zip are in the same directory

### III. Run the web-app through Docker

1. Open Docker Desktop, make sure you open it to the "Images" tab within the program. 
2. Open a Windows Powershell prompt and navigate to the folder which you have installed the web-app files. 
3. Enter the command `docker build -t gundb-webapp:release .`
4. After the command finishes, an "image" will be seen in the "Images" tab within Docker. Click on the image which should be titled "gundb-webapp" and click the "run" button.
5. When presented with a pop-up containing a dropdown of optional settings, open the dropdown and enter `8080` as the host port. Then click run in that pop-up. 
6. Immediately after clicking run, it will take you to the container that is made which runs the web-app. Click on the link that will be written as "8080:80" and it will automatically open web-app in a browser window. 
Another method for opening the web-app is you may enter the following into your browser URL bar, `localhost:8080`

