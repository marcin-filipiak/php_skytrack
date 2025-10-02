# IGC to JSON Flight Visualization

This project allows you to upload an IGC flight log file, convert it to JSON on the server, and visualize the flight path in 3D using CesiumJS.

## Features

* Upload `.IGC` files via a simple web form
* Convert flight data to `flight.json` using PHP
* Display a moving icon along the flight path with a trailing path in CesiumJS

## Setup

1. Clone this repository to your web server:

```bash
git clone <repository_url>
```

2. Make sure the web server has write permissions to save `flight.json`.

3. Open `visualization.html` and replace:

```javascript
Cesium.Ion.defaultAccessToken = 'YOUR TOKEN HERE';
```

with your own Cesium Ion access token.

4. Open `igc_upload.php` in your browser, upload a `.IGC` file, and follow the link to visualize the flight.

## File Structure

```
/www
  igc_upload.php       # upload form and PHP IGC to JSON conversion
  flight.json          # generated JSON flight file
  visualization.html   # CesiumJS visualization page
```

## Notes

* Only `.IGC` files are supported.
* The path trail in Cesium can be adjusted in `visualization.html` (e.g., `trailTime` and `width`).


