
<script>
    document.addEventListener('DOMContentLoaded', function () {
    
        const track = document.getElementById('carousel-track');
    
        if (!track) return;
    
        let isDragging = false;
        let startX = 0;
        let startScroll = 0;
    
        track.addEventListener('mousedown', function(e) {
    
            isDragging = true;
            startX = e.pageX;
            startScroll = track.scrollLeft;
    
            track.style.cursor = 'grabbing';
    
        });
    
        window.addEventListener('mouseup', function() {
    
            isDragging = false;
            track.style.cursor = 'grab';
    
        });
    
        window.addEventListener('mousemove', function(e) {
    
            if (!isDragging) return;
    
            e.preventDefault();
    
            track.scrollLeft = startScroll - (e.pageX - startX);
    
        });
    
    });
    </script>
    