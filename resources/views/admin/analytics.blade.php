@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Post Analytics</h1>
    <div class="row">
        <div class="col-md-6">
            <canvas id="viewsChart"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="likesChart"></canvas>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data for views chart
    var viewsData = {
        labels: {!! json_encode($postViews->pluck('title')) !!},
        datasets: [{
            label: 'Views',
            data: {!! json_encode($postViews->pluck('views_count')) !!},
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    };

    var viewsConfig = {
        type: 'bar',
        data: viewsData,
    };

    // Data for likes chart
    var likesData = {
        labels: {!! json_encode($postLikes->pluck('title')) !!},
        datasets: [{
            label: 'Likes',
            data: {!! json_encode($postLikes->pluck('likes_count')) !!},
            backgroundColor: 'rgba(75, 192, 192, 0.6)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    };

    var likesConfig = {
        type: 'bar',
        data: likesData,
    };

    // Render charts
    new Chart(document.getElementById('viewsChart'), viewsConfig);
    new Chart(document.getElementById('likesChart'), likesConfig);
</script>
@endsection
