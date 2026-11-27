
<script>
    document.addEventListener('keydown', function(e) {
    
        // Jangan mengganggu ketika pengguna sedang mengetik
        if (
            e.target.tagName === 'INPUT' ||
            e.target.tagName === 'TEXTAREA' ||
            e.target.isContentEditable
        ) return;
    
        const track = document.getElementById('carousel-track');
    
        if (!track) return;
    
        if (e.key === 'ArrowRight') {
    
            e.preventDefault();
    
            document.getElementById('carousel-next')?.click();
    
        }
    
        if (e.key === 'ArrowLeft') {
    
            e.preventDefault();
    
            document.getElementById('carousel-prev')?.click();
    
        }
    
    });
    </script>
    