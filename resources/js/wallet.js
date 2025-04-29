document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('progress-modal');
    const progressBar = document.getElementById('progress-bar');
    const adVideo = document.getElementById('ad-video');
    const adImage = document.getElementById('ad-image');
    const adTitle = document.getElementById('ad-title');
    const placeholderBox = document.getElementById('placeholder-box');
    const forfeitOption = document.getElementById('forfeit-option');
    const pauseButton = document.getElementById('pause-button');
    
    let activeInterval = null;
    let isProgressComplete = false;
    let isPaused = false;
    let currentProgress = 0;
    let startTime = null;
    let pausedTime = 0;
    let currentDuration = 0;
    let currentAdId = null;
    let currentAdTitle = '';

    // Ad button event handlers
    document.querySelectorAll('.ad-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const adId = btn.dataset.adId;
            const duration = parseInt(btn.dataset.duration);
            const mediaType = btn.dataset.mediaType;
            const title = btn.closest('.ad-card').querySelector('h3').textContent;
            
            openAdModal(adId, duration, mediaType, title);
        });
    });

    // Modal close button
    document.getElementById('close-modal-btn').addEventListener('click', attemptClose);
    modal.addEventListener('click', (e) => {
        if (e.target === modal) attemptClose();
    });

    // Pause button
    pauseButton.addEventListener('click', togglePause);

    // Forfeit option buttons
    document.getElementById('continue-btn').addEventListener('click', () => {
        forfeitOption.classList.add('hidden');
        togglePause(); // Folytatás
    });
    
    document.getElementById('forfeit-btn').addEventListener('click', () => {
        forfeitOption.classList.add('hidden');
        closeModal(true); // Feladás (no reward)
    });

    // Progress animation function
    function animateProgress(timestamp) {
        if (isPaused) return;
        
        const elapsed = timestamp - startTime;
        currentProgress = Math.min((elapsed / currentDuration) * 100, 100);
        
        progressBar.style.width = `${currentProgress}%`;
        
        if (currentProgress === 100) {
            isProgressComplete = true;
            setTimeout(() => closeModal(false), 500);
            return;
        }
        
        if (elapsed < currentDuration) {
            activeInterval = requestAnimationFrame(animateProgress);
        }
    }

    // Toggle pause state
    function togglePause() {
        isPaused = !isPaused;

        if (isPaused) {
            // Pause state
            pauseButton.textContent = 'Resume';
            pauseButton.classList.remove('bg-yellow-500', 'hover:bg-yellow-600');
            pauseButton.classList.add('bg-green-500', 'hover:bg-green-600');
            
            pausedTime = performance.now();
            
            if (activeInterval) {
                cancelAnimationFrame(activeInterval);
                activeInterval = null;
            }
        } else {
            // Resume state
            pauseButton.textContent = 'Pause';
            pauseButton.classList.remove('bg-green-500', 'hover:bg-green-600');
            pauseButton.classList.add('bg-yellow-500', 'hover:bg-yellow-600');
            
            // Adjust start time to account for paused duration
            startTime += (performance.now() - pausedTime);
            
            activeInterval = requestAnimationFrame(animateProgress);
        }
    }

    // Show forfeit option
    function showForfeitOption() {
        forfeitOption.classList.remove('hidden');
    }

    // Open ad modal
    function openAdModal(adId, duration, mediaType, title) {
        // Reset state
        progressBar.style.width = '0%';
        adVideo.style.display = 'none';
        adImage.style.display = 'none';
        placeholderBox.style.display = 'none';
        isProgressComplete = false;
        isPaused = false;
        currentProgress = 0;
        currentAdId = adId;
        currentDuration = duration;
        currentAdTitle = title;
        
        // Update title
        adTitle.textContent = title;
        
        // Reset pause button
        pauseButton.textContent = 'Pause';
        pauseButton.classList.remove('bg-green-500', 'hover:bg-green-600');
        pauseButton.classList.add('bg-yellow-500', 'hover:bg-yellow-600');
        
        // Show modal
        modal.classList.remove('hidden');
        modal.style.display = 'flex';

        // Load media based on type
        if (mediaType === 'video') {
            adVideo.src = `/ads/${adId}/video`;
            adVideo.onloadeddata = () => {
                adVideo.style.display = 'block';
                placeholderBox.style.display = 'none'; // Hiding the placeholder if video loads
            };
            adVideo.onerror = () => {
                adVideo.style.display = 'none';
                placeholderBox.style.display = 'flex';
            };
        } else {
            adImage.src = `/ads/${adId}/image`;
            adImage.onload = () => {
                adImage.style.display = 'block';
                placeholderBox.style.display = 'none'; // Hiding the placeholder if image loads
            };
            adImage.onerror = () => {
                adImage.style.display = 'none';
                placeholderBox.style.display = 'flex';
            };
        }

        // Start progress animation
        progressBar.style.transition = 'width linear';
        startTime = performance.now();
        activeInterval = requestAnimationFrame(animateProgress);
    }

    // Attempt to close modal
    function attemptClose() {
        if (!isProgressComplete && !isPaused) {
            // Pause and show forfeit option
            togglePause();
            showForfeitOption();
            return;
        }
        closeModal(!isProgressComplete);
    }

    // Close modal and process reward
    function closeModal(noReward = false) {
        // Calculate watched seconds
        const watchedSeconds = Math.floor((currentProgress / 100) * (currentDuration / 1000));
        
        // Process the ad view and reward if appropriate
        if (!noReward && currentAdId) {
            fetch('/wallet/process-ad', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    ad_id: currentAdId,
                    watched_seconds: watchedSeconds
                })
            })
            .then(response => response.json())
            .then(data => {
                // Update balance display
                document.getElementById('balance-amount').textContent = `$ ${parseFloat(data.new_balance).toFixed(2)}`;
                
                // Show reward notification
                alert(`You earned $ ${data.reward.toFixed(2)} for watching the ad!`);
            })
            .catch(error => {
                console.error('Error processing ad reward:', error);
                alert('Error processing reward. Please try again.');
            });
        } else if (noReward) {
            alert('No reward was given since you didn\'t complete the ad.');
        }
        
        // Hide modal
        modal.classList.add('hidden');
        modal.style.display = 'none';
        
        // Reset state
        progressBar.style.width = '0%';
        adVideo.src = '';
        adImage.src = '';
        adVideo.style.display = 'none';
        adImage.style.display = 'none';
        placeholderBox.style.display = 'none';
        isPaused = false;
        
        // Cancel animation
        if (activeInterval) {
            cancelAnimationFrame(activeInterval);
            activeInterval = null;
        }
        
        // Hide forfeit option if visible
        forfeitOption.classList.add('hidden');
    }
});
