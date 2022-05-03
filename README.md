## Simple Weather Forecast Web App
A web application that developed using VueJS 3 and Laravel Framework

### UI and UX Implementation
The UI Components used on the web application was Bootstrap 5.

    1. I desinged the header keep it simple because the user needs to see first the weather forecast details.
    2. Create a search function for the mapping and search the Japan's venues they want.
    3. I create a Map Container and used the <a href="https://apidocs.geoapify.com/samples/maps/vue/#project">maplibre-gl</a> dependencies as Geoapify was suggested to use to diplay the map result.
    4. After the map you can see a default tab and that indicates for the pre-defined cities in japan that they can access and see the weather forecast with hours,
    temperature, wind speed & destination.
    5. the forecast display is a draggable scroll to left and right
    6. the third section of the content is about the location where you selected or search


### Backend Implementation
The backend was made of Laravel framework and it was setup to process the API returns and connection using the cURL process 
Routes that created for the functionalities:

    1. http://127.0.0.1:8001/api/forecast/getByCityName 
    Method: Post
    Payload: {
        "city_name":"Yokohama",
        "country_code": "JP" 
    }

    2. http://127.0.0.1:8001/api/forecast/getMapsLocation
    Method: Post
    Payload: {
        "query": "Tokyo"
    }

### Code Implementation
- For the backend i put the Credentials and API Url's on to the .env file to hide some confidential details and pass it to the routes and controller using env() function of the laravel framework. to return the json responses I used the cURL function.

- For the frontend I installed dependencies I need to do some connection to backend and for the UI structure. For connecting in to the backend I used Axios to retrieve the data from the created API routes on the laravel.

### File Folder Structure
<ul>
    <li>
        backend
        <ul>
            <li>app</li>
            <li>bootstrap</li>
            <li>config</li>
            <li>database</li>
            <li>public</li>
            <li>resource</li>
            <li>routes</li>
            <li>storage</li>
            <li>tests</li>
        </ul>
    </li>
    <li>
        frontend
        <ul>
            <li>public</li>
            <li>src</li>
        </ul>
    </li>
</ul>

## Requirement 
- [vue cli](https://cli.vuejs.org/guide/installation.html)
- [Node](https://nodejs.org/es/blog/release/v12.13.0/)
- [composer](https://getcomposer.org/download/)

## Running the App
1. go to frontend directory and execute the installation of node modules dependencies
2. after the installation you can run the vue js application by executing the command 
- vue ui / npm run serve

3. go to backend directory run the composer install if needed
4. after that run
- php artisan serve