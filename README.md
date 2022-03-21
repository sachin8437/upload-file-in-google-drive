# upload-file-in-google-drive

Create "uploads" folder in files root



/ ***************************************** /

Need to Client ID and Client secret follow the steps

Steps for get Credentials in our google account   

 1. Go to the Google API Console. https://console.cloud.google.com/
 
 2. Select an existing project from the projects list, or click NEW PROJECT to create a new project
	Type the Project Name.
	
 3.  Select the newly created project and enable the Google Drive API service.
	In the sidebar, select Library under the APIs & Services section.
	Search for the Google Drive API service in the API list and select Google Drive API.
	Click the ENABLE button to make the Google Drive API Library available.

 4. In the sidebar, select Credentials under the APIs & Services section.

 5. Select the OAuth consent screen tab, specify the consent screen settings.
	Enter the Application name.
	Choose a Support email.
	Specify the Authorized domains which will be allowed to authenticate using OAuth.
	Click the Save button.

 6. Select the Credentials tab, click the Create credentials drop-down and select OAuth client ID.
	In the Application type section, select Web application.
	In the Authorized redirect URIs field, specify the redirect URL.
	Click the Create button.

A dialog box will appear with OAuth client details, note the Client ID and Client secret for later use in the script. This Client ID and Client secret allow you to access the Google Drive API.


 Full information follow this : : https://www.codexworld.com/upload-file-to-google-drive-using-php/
