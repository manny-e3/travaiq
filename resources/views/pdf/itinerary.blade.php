<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trip Itinerary</title>
    <style>
        {
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
            color: #333;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #ff7f50, #ff6347);
            padding: 30px;
            position: relative;
        }
        
        .logo-container {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 150px;
            height: auto;
        }
        
        .logo-container img {
            width: 100%;
            height: auto;
            object-fit: contain;
        }
        
        .header h1 {
            font-size: 3.5rem;
            font-weight: 900;
            margin-bottom: 10px;
        }
        
        .header .subtitle {
            font-size: 2rem;
            font-weight: 300;
            opacity: 0.9;
        }
        
        .trip-details {
            padding: 30px;
            background: #fafafa;
            border-bottom: 3px solid #9575cd;
        }
        
        .detail-row {
            width: 100%;
            margin-bottom: 15px;
            overflow: hidden;
        }
        
        .detail-item {
            width: 48%;
            float: left;
            margin-right: 4%;
        }
        
        .detail-item:last-child {
            margin-right: 0;
        }
        
        .detail-label {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 5px;
            color: #333;
        }
        
        .detail-value {
            color: #666;
            font-size: 1rem;
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }
        
        .itinerary {
            padding: 20px;
        }
        
        .day-block {
            width: 100%;
            margin-bottom: 30px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            border: 1px solid #eee;
        }
        
        .day-label {
            background: #9575cd;
            color: white;
            width: 100px;
            height: 60px;
            float: left;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.2rem;
        }
        
        .day-content {
            margin-left: 100px;
            background: white;
            border-left: 1px solid #eee;
            min-height: 60px;
        }
        
        .day-header {
            background: #f8f8f8;
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
        }
        
        .day-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #333;
        }
        
        .day-theme {
            font-size: 1.1rem;
            color: #666;
            margin-top: 5px;
        }
        
        .activities {
            padding: 0;
        }
        
        .activity {
            width: 100%;
            padding: 15px 20px;
            border-bottom: 1px solid #f0f0f0;
            overflow: hidden;
        }
        
        .activity:hover {
            background-color: #f9f9f9;
        }
        
        .activity:last-child {
            border-bottom: none;
        }
        
        .time {
            width: 80px;
            float: left;
            font-weight: 600;
            color: #9575cd;
            font-size: 0.95rem;
        }
        
        .activity-description {
            margin-left: 90px;
            color: #555;
            line-height: 1.4;
        }
        
        /* Clear floats */
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
        
        .trip-details::after,
        .detail-row::after,
        .day-block::after,
        .activity::after {
            content: "";
            display: table;
            clear: both;
        }
            .container {
                margin: 10px;
                border-radius: 10px;
            }
            
            .header h1 {
                font-size: 2.5rem;
            }
            
            .header .subtitle {
                font-size: 1.5rem;
            }
            
            .detail-row {
                flex-direction: column;
                gap: 15px;
            }
            
            .day-block {
                flex-direction: column;
            }
            
            .day-label {
                writing-mode: horizontal-tb;
                text-orientation: mixed;
                padding: 15px;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo-container">
            <!-- <img src="{{ asset('tavaiqPNG.png') }}" alt="Travaiq Logo"> -->
            </div>
            <h1>{{ $tripDetails['name'] ?? 'Trip' }}</h1>
            <div class="subtitle">Itinerary for {{ $tripDetails['location'] }}</div>
        </div>
        
        <div class="trip-details">
            <div class="detail-row">
                <div class="detail-item">
                    <div class="detail-label">Start Date</div>
                    <div class="detail-value">
                        @if(count($itineraries) > 0)
                            {{ \Carbon\Carbon::parse($locationOverview->start_date)->format('d/m/Y') }}
                        @else
                            --/--/----
                        @endif
                    </div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">End Date</div>
                    <div class="detail-value">
                        @if(count($itineraries) > 0)
                            {{ \Carbon\Carbon::parse($locationOverview->start_date)->addDays(count($itineraries) - 1)->format('d/m/Y') }}
                        @else
                            --/--/----
                        @endif
                    </div>
                </div>
            </div>
            <!-- <div class="detail-row">
                <div class="detail-item">
                    <div class="detail-label">Destination</div>
                    <div class="detail-value">{{ $tripDetails['location'] }}</div>
                </div>
            </div> -->
            <!-- <div class="detail-row">
                <div class="detail-item">
                    <div class="detail-label">Transportation</div>
                    <div class="detail-value">{{ $tripDetails['transportation'] ?? 'Not specified' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Accommodation</div>
                    <div class="detail-value">{{ $tripDetails['accommodation'] ?? 'Not specified' }}</div>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-item">
                    <div class="detail-label">Meals Included</div>
                    <div class="detail-value">{{ $tripDetails['meals'] ?? 'Not specified' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Special Requirements</div>
                    <div class="detail-value">{{ $tripDetails['special_requirements'] ?? 'None' }}</div>
                </div>
            </div> -->
        </div>
        
        <div class="itinerary">

            @foreach ($itineraries as $itinerary)
                <div class="day-block">
                    <div class="day-label">DAY {{ $itinerary->day }}</div>
                    <div class="day-content">
                        <div class="day-header">
                            <div class="day-title">Time {{ \Carbon\Carbon::parse($locationOverview->start_date)->addDays($itinerary->day - 1)->format('D, d M') }}</div>
                            <div class="day-theme">Activity - Explore the City</div>
                        </div>
                        <div class="activities">
                            @foreach ($itinerary->activities as $activity)
                                <div class="activity">
                                    <div class="time">{{ $activity->best_time }}</div>
                                    <div class="activity-description">{{ $activity->description }} -- <strong>{{ $activity->name }}</strong></div>
                                </div>
                            @endforeach
                         
                        </div>
                    </div>
                </div>
            @endforeach
         
        </div>
    </div>
</body>
</html>