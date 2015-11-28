## jobEQ API authorization

Authorization is required to use [jobEQ API](http://www.jobeq.info/api/). Application should provide access token in every API request. Authorization is based on oAuth2 protocol, implicit scenario is used. Note that in order to use jobEQ API application also needs to receive a secret key and ID, please mail jobEQ to register your app. 

### How to start using jobEQ API ?

1. Register your application and receive secret key, by sending email to jobEQ.
2. Authorize application access through jobEQ oAuth. 
3. Call API functions through http

### Authorization flow

All API requests are executed on behalf of HR user, jobEQ has to know which resources are accessible for client application, so authorization procedure will ask HR user to confirm that application can use his/her data retrieved from jobEQ. 

1. When registering application in jobEQ redirection url should be provided. HR user will be redirected to that url after authentication in jobEQ. 
2. Before calling jobEQ API client application should redirect user to jobEQ authorization service, sending application ID in request, so jobEQ knows where request is coming from. 
3. jobEQ authorization service will perform HR user authentication and will redirect back to application url mentioned in 1. The redirection request will also contain authorization code. 
4. Client application software should exchange authorization code and app secret to api access token. 
5. Client application can now perform API request adding access token to every API request.
