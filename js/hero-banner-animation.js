/**
 * Hero Banner Text Animation
 * Creates a text flip animation that cycles through different phrases
 */

document.addEventListener('DOMContentLoaded', function() {
    // Get all the elements needed for animation
    const baseTextElement = document.getElementById('base-text');
    const flipContainer = document.getElementById('flip-container');
    const flipTextElement = document.getElementById('flip-text');
    const words = (typeof window.flipWords !== 'undefined' && Array.isArray(window.flipWords)) ? window.flipWords : null;
    
    // Exit if elements not found
    if (!baseTextElement || !flipContainer || !flipTextElement || !words || words.length === 0) {
        // Silently exit when the hero banner or flip words are not present
        return;
    }
    
    // Add CSS for the flip animation
    const style = document.createElement('style');
    style.textContent = `
        .flip-container {
            display: inline-block;
            position: relative;
            min-width: 150px;
            text-align: left;
        }
        .flip-text {
            display: inline-block;
            position: relative;
            animation: flipIn 0.5s ease-out forwards;
        }
        .flip-text.flip-out {
            animation: flipOut 0.5s ease-in forwards;
        }
        @keyframes flipIn {
            0% {
                transform: rotateX(90deg);
                opacity: 0;
            }
            100% {
                transform: rotateX(0deg);
                opacity: 1;
            }
        }
        @keyframes flipOut {
            0% {
                transform: rotateX(0deg);
                opacity: 1;
            }
            100% {
                transform: rotateX(-90deg);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
    
    // Initialize with the first flip word
    let currentWordIndex = 0;
    flipTextElement.textContent = words[currentWordIndex];
    
    // Function to flip to the next word
    function flipToNextWord() {
        // Start the flip out animation
        flipTextElement.classList.add('flip-out');
        
        // After flip out animation completes, change the text and flip in
        setTimeout(() => {
            // Update to next word in the array
            currentWordIndex = (currentWordIndex + 1) % words.length;
            flipTextElement.textContent = words[currentWordIndex];
            
            // Remove flip-out class and add flip-in animation
            flipTextElement.classList.remove('flip-out');
            
            // Schedule the next flip
            setTimeout(flipToNextWord, 3000); // Wait 3 seconds before flipping to the next word
        }, 500); // This should match the duration of the flip-out animation
    }
    
    // Start the flip animation after a delay
    setTimeout(flipToNextWord, 3000);
});
