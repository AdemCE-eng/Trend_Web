// Enhanced tweet interactions for better UX

// Make shareTweet function globally available
window.shareTweet = function(tweetUrl, tweetContent, userName) {
    // Check if tweetUrl already contains the full URL or just the path
    const fullUrl = tweetUrl.startsWith('http') ? tweetUrl : window.location.origin + tweetUrl;
    const shareText = `"${tweetContent}" - by ${userName}`;
    
    console.log('Tweet URL:', tweetUrl);
    console.log('Full URL:', fullUrl);
    
    if (navigator.share) {
        navigator.share({
            title: `Tweet by ${userName} on Trends`,
            text: shareText,
            url: fullUrl
        }).catch(err => {
            console.log('Error sharing:', err);
            // Fallback to clipboard
            copyToClipboard(fullUrl, shareText);
        });
    } else {
        // Fallback: copy to clipboard
        copyToClipboard(fullUrl, shareText);
    }
};

// Toggle like function
window.toggleLike = async function(tweetId, button) {
    if (!button) return;
    
    try {
        // Add animation
        button.classList.add('animate-pulse');
        
        const response = await fetch(`/tweet/${tweetId}/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        });
        
        if (!response.ok) {
            if (response.status === 401) {
                window.location.href = '/login';
                return;
            }
            throw new Error('Failed to toggle like');
        }
        
        const data = await response.json();
        
        // Update button state
        const icon = button.querySelector('span[class*="heart"]');
        const countSpan = button.querySelector('.likes-count');
        
        if (data.is_liked) {
            button.classList.remove('text-base-content/60');
            button.classList.add('text-red-500');
            icon.className = icon.className.replace('icon-[tabler--heart]', 'icon-[tabler--heart-filled]');
            button.dataset.liked = 'true';
            
            // Create floating heart animation
            createFloatingHeart(button);
        } else {
            button.classList.remove('text-red-500');
            button.classList.add('text-base-content/60');
            icon.className = icon.className.replace('icon-[tabler--heart-filled]', 'icon-[tabler--heart]');
            button.dataset.liked = 'false';
        }
        
        // Update count
        if (countSpan) {
            countSpan.textContent = data.likes_count;
        }
        
    } catch (error) {
        console.error('Error toggling like:', error);
        showToast('Failed to like tweet');
    } finally {
        // Remove animation
        setTimeout(() => {
            button.classList.remove('animate-pulse');
        }, 300);
    }
};

// Toggle retweet function
window.toggleRetweet = async function(tweetId, button) {
    if (!button) return;
    
    try {
        // Add animation
        const icon = button.querySelector('span[class*="repeat"]');
        icon.style.transform = 'rotate(180deg)';
        
        const response = await fetch(`/tweet/${tweetId}/retweet`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        });
        
        if (!response.ok) {
            if (response.status === 401) {
                window.location.href = '/login';
                return;
            }
            throw new Error('Failed to toggle retweet');
        }
        
        const data = await response.json();
        
        // Update button state
        const countSpan = button.querySelector('.retweets-count');
        
        if (data.is_retweeted) {
            button.classList.remove('text-base-content/60');
            button.classList.add('text-green-500');
            button.dataset.retweeted = 'true';
        } else {
            button.classList.remove('text-green-500');
            button.classList.add('text-base-content/60');
            button.dataset.retweeted = 'false';
        }
        
        // Update count
        if (countSpan) {
            countSpan.textContent = data.retweets_count;
        }
        
        // Reset icon rotation
        setTimeout(() => {
            icon.style.transform = '';
        }, 300);
        
        showToast(data.is_retweeted ? 'Retweeted!' : 'Retweet removed');
        
    } catch (error) {
        console.error('Error toggling retweet:', error);
        showToast('Failed to retweet');
        
        // Reset icon rotation on error
        const icon = button.querySelector('span[class*="repeat"]');
        if (icon) {
            setTimeout(() => {
                icon.style.transform = '';
            }, 300);
        }
    }
};

// Toggle follow function
window.toggleFollow = async function(userId, button) {
    if (!button) return;
    
    try {
        // Add loading state
        button.disabled = true;
        button.classList.add('loading');
        
        const response = await fetch(`/user/${userId}/follow`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        });
        
        if (!response.ok) {
            if (response.status === 401) {
                window.location.href = '/login';
                return;
            }
            throw new Error('Failed to toggle follow');
        }
        
        const data = await response.json();
        
        // Update button state
        const icon = button.querySelector('.follow-icon');
        const text = button.querySelector('.follow-text');
        
        if (data.is_following) {
            button.classList.remove('btn-primary');
            button.classList.add('btn-outline');
            icon.className = icon.className.replace('icon-[tabler--user-plus]', 'icon-[tabler--user-minus]');
            text.textContent = 'Unfollow';
            button.dataset.following = 'true';
            showToast('Following!');
        } else {
            button.classList.remove('btn-outline');
            button.classList.add('btn-primary');
            icon.className = icon.className.replace('icon-[tabler--user-minus]', 'icon-[tabler--user-plus]');
            text.textContent = 'Follow';
            button.dataset.following = 'false';
            showToast('Unfollowed');
        }
        
    } catch (error) {
        console.error('Error toggling follow:', error);
        showToast('Failed to update follow status');
    } finally {
        // Remove loading state
        button.disabled = false;
        button.classList.remove('loading');
    }
};

// Helper function for copying to clipboard
function copyToClipboard(url, text) {
    // Try to copy the URL first, then fallback to text
    navigator.clipboard.writeText(url).then(() => {
        showToast('Tweet link copied to clipboard!');
    }).catch(() => {
        // If URL copy fails, try copying the text with URL
        navigator.clipboard.writeText(`${text}\n${url}`).then(() => {
            showToast('Tweet content and link copied to clipboard!');
        }).catch(() => {
            showToast('Unable to copy to clipboard');
        });
    });
}

function showToast(message) {
    // Create a simple toast notification
    const toast = document.createElement('div');
    toast.textContent = message;
    toast.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #1f2937;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        font-size: 14px;
        z-index: 1000;
        animation: slideInFromRight 0.3s ease, fadeOut 0.3s ease 2.7s forwards;
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}

document.addEventListener('DOMContentLoaded', function() {
    // Add smooth scroll behavior for navigation
    document.documentElement.style.scrollBehavior = 'smooth';

    // Enhanced button interactions
    initializeButtonInteractions();
    
    // Image loading states
    initializeImageLoading();
    
    // Keyboard navigation
    initializeKeyboardNavigation();
});

function initializeButtonInteractions() {
    // Like button enhancement
    document.querySelectorAll('[title="Like this tweet"]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Add a temporary animation class
            this.classList.add('animate-pulse');
            
            // Toggle liked state (you would implement actual API call here)
            const icon = this.querySelector('span[class*="heart"]');
            const isLiked = this.dataset.liked === 'true';
            
            if (!isLiked) {
                icon.style.color = '#ef4444';
                this.dataset.liked = 'true';
                
                // Create floating heart animation
                createFloatingHeart(this);
            } else {
                icon.style.color = '';
                this.dataset.liked = 'false';
            }
            
            // Remove animation class
            setTimeout(() => {
                this.classList.remove('animate-pulse');
            }, 300);
        });
    });

    // Retweet button enhancement
    document.querySelectorAll('[title="Retweet"]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const icon = this.querySelector('span[class*="repeat"]');
            const isRetweeted = this.dataset.retweeted === 'true';
            
            if (!isRetweeted) {
                icon.style.color = '#22c55e';
                this.dataset.retweeted = 'true';
                
                // Add rotation animation
                icon.style.transform = 'rotate(180deg)';
                setTimeout(() => {
                    icon.style.transform = '';
                }, 300);
            } else {
                icon.style.color = '';
                this.dataset.retweeted = 'false';
            }
        });
    });
}

function createFloatingHeart(button) {
    const heart = document.createElement('div');
    heart.innerHTML = '❤️';
    heart.style.cssText = `
        position: absolute;
        font-size: 14px;
        pointer-events: none;
        z-index: 1000;
        animation: floatUp 1s ease-out forwards;
    `;
    
    // Position relative to button
    const rect = button.getBoundingClientRect();
    heart.style.left = rect.left + rect.width / 2 + 'px';
    heart.style.top = rect.top + 'px';
    
    document.body.appendChild(heart);
    
    // Remove after animation
    setTimeout(() => {
        heart.remove();
    }, 1000);
}

function initializeImageLoading() {
    document.querySelectorAll('img[src*="avatar"]').forEach(img => {
        // Add loading state
        img.classList.add('shimmer');
        
        img.addEventListener('load', function() {
            this.classList.remove('shimmer');
            this.style.opacity = '0';
            this.style.transition = 'opacity 0.3s ease';
            
            setTimeout(() => {
                this.style.opacity = '1';
            }, 10);
        });
        
        img.addEventListener('error', function() {
            this.classList.remove('shimmer');
            this.src = '/images/default-avatar.png';
        });
    });
}

function initializeKeyboardNavigation() {
    // Add keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Press 'L' to like the first visible tweet
        if (e.key.toLowerCase() === 'l' && !e.ctrlKey && !e.metaKey) {
            const firstLikeButton = document.querySelector('[title="Like this tweet"]:not([disabled])');
            if (firstLikeButton) {
                firstLikeButton.click();
            }
        }
        
        // Press 'R' to reply to the first visible tweet
        if (e.key.toLowerCase() === 'r' && !e.ctrlKey && !e.metaKey) {
            const firstReplyButton = document.querySelector('[title="Reply to this tweet"]');
            if (firstReplyButton) {
                firstReplyButton.click();
            }
        }
    });
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes floatUp {
        to {
            transform: translateY(-30px);
            opacity: 0;
        }
    }
    
    @keyframes slideInFromRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes fadeOut {
        to {
            opacity: 0;
            transform: translateX(100%);
        }
    }
`;
document.head.appendChild(style);
