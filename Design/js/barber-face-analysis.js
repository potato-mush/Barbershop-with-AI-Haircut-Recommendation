let stream;
let faceDetected = false;
let modelsLoaded = false;
let currentFaceShape = null;

async function loadModels() {
    const MODEL_URL = 'https://cdn.jsdelivr.net/npm/@vladmandic/face-api/model';
    
    try {
        await Promise.all([
            faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL),
            faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
            faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL),
            faceapi.nets.faceExpressionNet.loadFromUri(MODEL_URL)
        ]);
        modelsLoaded = true;
        console.log("Face-API models loaded successfully");
        return true;
    } catch (error) {
        console.error("Error loading models:", error);
        return false;
    }
}

function analyzeFaceShape(landmarks, canvas, displaySize) {
    const jaw = landmarks.getJawOutline();
    const leftEye = landmarks.getLeftEye();
    const rightEye = landmarks.getRightEye();
    const nose = landmarks.getNose();
    
    const leftEyeOuter = leftEye[0];
    const rightEyeOuter = rightEye[3];
    const noseTop = nose[0];
    
    const avgEyeY = (leftEyeOuter.y + rightEyeOuter.y) / 2;
    const foreheadY = avgEyeY - 60;
    
    const foreheadBaseLeft = jaw[1];
    const foreheadBaseRight = jaw[15];
    
    const foreheadLeft = { x: foreheadBaseLeft.x, y: foreheadY };
    const foreheadRight = { x: foreheadBaseRight.x, y: foreheadY };
    
    const cheekLeft = jaw[3];
    const cheekRight = jaw[13];
    const jawLeft = jaw[4];
    const jawRight = jaw[12];
    const chinLeft = jaw[7];
    const chinRight = jaw[9];
    const chinPoint = jaw[8];
    
    const topReference = foreheadY;
    
    const foreheadWidth = Math.abs(foreheadRight.x - foreheadLeft.x);
    const cheekWidth = Math.abs(cheekRight.x - cheekLeft.x);
    const jawWidth = Math.abs(jawRight.x - jawLeft.x);
    const chinWidth = Math.abs(chinRight.x - chinLeft.x);
    const faceLength = Math.abs(chinPoint.y - topReference);
    
    const maxWidth = Math.max(foreheadWidth, cheekWidth, jawWidth);
    
    const normForehead = foreheadWidth / maxWidth;
    const normCheek = cheekWidth / maxWidth;
    const normJaw = jawWidth / maxWidth;
    const normChin = chinWidth / maxWidth;
    
    const lengthWidthRatio = faceLength / maxWidth;
    
    if (canvas && displaySize) {
        const ctx = canvas.getContext('2d');
        ctx.lineWidth = 3;
        
        ctx.strokeStyle = '#00FF00';
        ctx.beginPath();
        ctx.moveTo(foreheadLeft.x, foreheadLeft.y);
        ctx.lineTo(foreheadRight.x, foreheadRight.y);
        ctx.stroke();
        ctx.fillStyle = '#00FF00';
        ctx.font = 'bold 14px Arial';
        ctx.fillText('Forehead', foreheadLeft.x - 70, foreheadLeft.y - 5);
        
        ctx.strokeStyle = '#FFFF00';
        ctx.beginPath();
        ctx.moveTo(cheekLeft.x, cheekLeft.y);
        ctx.lineTo(cheekRight.x, cheekRight.y);
        ctx.stroke();
        ctx.fillStyle = '#FFFF00';
        ctx.fillText('Cheeks', cheekLeft.x - 60, cheekLeft.y - 5);
        
        ctx.strokeStyle = '#FFA500';
        ctx.beginPath();
        ctx.moveTo(jawLeft.x, jawLeft.y);
        ctx.lineTo(jawRight.x, jawRight.y);
        ctx.stroke();
        ctx.fillStyle = '#FFA500';
        ctx.fillText('Jawline', jawLeft.x - 60, jawLeft.y + 20);
        
        ctx.strokeStyle = '#FF0000';
        ctx.beginPath();
        ctx.moveTo(chinLeft.x, chinLeft.y);
        ctx.lineTo(chinRight.x, chinRight.y);
        ctx.stroke();
        ctx.fillStyle = '#FF0000';
        ctx.fillText('Chin', chinLeft.x - 45, chinLeft.y + 15);
        
        ctx.strokeStyle = '#00FFFF';
        ctx.setLineDash([5, 5]);
        ctx.beginPath();
        ctx.moveTo(chinPoint.x, topReference);
        ctx.lineTo(chinPoint.x, chinPoint.y);
        ctx.stroke();
        ctx.setLineDash([]);
        ctx.fillStyle = '#00FFFF';
        ctx.fillText('Length', chinPoint.x + 10, (topReference + chinPoint.y) / 2);
    }
    
    const widthVariation = Math.max(normForehead, normCheek, normJaw) - Math.min(normForehead, normCheek, normJaw);
    const foreheadToJaw = normForehead - normJaw;
    const cheekToDiamond = Math.abs(normCheek - Math.max(normForehead, normJaw));
    
    const isWidestForehead = normForehead >= normCheek && normForehead >= normJaw;
    const isWidestCheeks = normCheek >= normForehead && normCheek >= normJaw;
    const isWidestJaw = normJaw >= normForehead && normJaw >= normCheek;
    const widestArea = isWidestForehead ? 'FOREHEAD' : isWidestCheeks ? 'CHEEKS' : 'JAW';
    
    console.log('=== FACE SHAPE DETECTION ===');
    console.log('📏 Width Measurements:');
    console.log('  Forehead:', foreheadWidth.toFixed(1), `[${(normForehead * 100).toFixed(0)}%]`);
    console.log('  Cheeks:  ', cheekWidth.toFixed(1), `[${(normCheek * 100).toFixed(0)}%]`);
    console.log('  Jawline: ', jawWidth.toFixed(1), `[${(normJaw * 100).toFixed(0)}%]`);
    console.log('  L/W Ratio:', lengthWidthRatio.toFixed(3));
    console.log('  Widest Area:', widestArea);
    
    const scores = {
        oval: 0,
        round: 0,
        square: 0,
        long: 0,
        heart: 0,
        diamond: 0
    };
    
    // OVAL SCORING
    if (lengthWidthRatio >= 1.20 && lengthWidthRatio <= 1.45) scores.oval += 50;
    if (foreheadToJaw >= 0.08 && foreheadToJaw <= 0.22) scores.oval += 40;
    if (normCheek >= 0.88) scores.oval += 20;
    if (normJaw >= 0.75 && normJaw < 0.85) scores.oval += 20;
    if (lengthWidthRatio < 1.08) scores.oval -= 50;
    
    // ROUND SCORING
    if (lengthWidthRatio < 1.08) scores.round += 50;
    if (widthVariation < 0.12) scores.round += 35;
    if (normJaw >= 0.85 && normForehead >= 0.85) scores.round += 20;
    if (lengthWidthRatio > 1.15) scores.round -= 50;
    
    // SQUARE SCORING
    if (normJaw >= 0.88) scores.square += 60;
    if (lengthWidthRatio >= 0.98 && lengthWidthRatio <= 1.08) scores.square += 50;
    if (widthVariation < 0.10) scores.square += 50;
    if (Math.abs(normForehead - normJaw) < 0.08) scores.square += 40;
    if (lengthWidthRatio > 1.50) scores.square -= 50;
    
    // LONG SCORING
    if (lengthWidthRatio > 1.48) scores.long += 55;
    if (widthVariation < 0.15) scores.long += 30;
    if (lengthWidthRatio < 1.30) scores.long -= 50;
    
    // HEART SCORING
    if (isWidestForehead && normJaw < 0.75) scores.heart += 45;
    if (foreheadToJaw > 0.28) scores.heart += 50;
    if (normChin < 0.62) scores.heart += 30;
    if (normJaw >= 0.82) scores.heart -= 50;
    
    // DIAMOND SCORING
    if (isWidestCheeks && normCheek >= 0.96) scores.diamond += 50;
    if (normForehead < 0.88 && normJaw < 0.88) scores.diamond += 40;
    if (!isWidestCheeks) scores.diamond -= 50;
    
    let detectedShape = 'oval';
    let maxScore = 0;
    
    console.log('🎯 Shape Scores:');
    for (const [shape, score] of Object.entries(scores)) {
        console.log(`  ${shape.padEnd(8)}: ${score} points`);
        if (score > maxScore) {
            maxScore = score;
            detectedShape = shape;
        }
    }
    
    console.log('✅ DETECTED:', detectedShape.toUpperCase());
    console.log('============================');
    
    return {
        shape: detectedShape,
        measurements: {
            forehead: (normForehead * 100).toFixed(0),
            cheeks: (normCheek * 100).toFixed(0),
            jaw: (normJaw * 100).toFixed(0),
            ratio: lengthWidthRatio.toFixed(2)
        }
    };
}

async function openAnalysisModal() {
    const modal = document.getElementById('analysisModal');
    modal.style.display = 'flex';
    
    const video = document.getElementById('video');
    const startAnalysisBtn = document.getElementById('startAnalysis');
    
    try {
        stream = await navigator.mediaDevices.getUserMedia({ 
            video: { width: 480, height: 360 } 
        });
        
        video.srcObject = stream;
        startAnalysisBtn.disabled = false;
        startAnalysisBtn.textContent = 'Start Analysis';
    } catch (err) {
        console.error('Error accessing camera:', err);
        alert('Unable to access camera. Please ensure you have granted camera permissions.');
    }
}

function closePopup(popupId) {
    document.getElementById(popupId).style.display = 'none';
    
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    }
    
    const startAnalysisBtn = document.getElementById('startAnalysis');
    if (startAnalysisBtn) {
        startAnalysisBtn.textContent = 'Start Analysis';
        startAnalysisBtn.style.backgroundColor = '';
        startAnalysisBtn.disabled = false;
    }
    
    const canvas = document.getElementById('overlay');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    }
    
    const resultsDiv = document.getElementById('analysisResults');
    if (resultsDiv) {
        resultsDiv.style.display = 'none';
    }
}

async function retakeAnalysis() {
    const resultsDiv = document.getElementById('analysisResults');
    const faceShapeDiv = document.getElementById('faceShapeResult');
    const recommendationsDiv = document.getElementById('recommendations');
    
    if (resultsDiv) resultsDiv.style.display = 'none';
    if (faceShapeDiv) faceShapeDiv.innerHTML = '';
    if (recommendationsDiv) recommendationsDiv.innerHTML = '';
    
    faceDetected = false;
    currentFaceShape = null;
    
    const canvas = document.getElementById('overlay');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    }
    
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    }
    
    const video = document.getElementById('video');
    const startBtn = document.getElementById('startAnalysis');
    
    try {
        stream = await navigator.mediaDevices.getUserMedia({ 
            video: { width: 480, height: 360 } 
        });
        
        video.srcObject = stream;
        
        if (startBtn) {
            startBtn.disabled = false;
            startBtn.textContent = 'Start Analysis';
            startBtn.style.backgroundColor = '';
        }
    } catch (err) {
        console.error('Error restarting camera:', err);
        alert('Unable to restart camera. Please ensure camera permissions are granted.');
    }
}

async function displayRecommendations(faceShape, measurements) {
    const resultsDiv = document.getElementById('analysisResults');
    const faceShapeDiv = document.getElementById('faceShapeResult');
    const recommendationsDiv = document.getElementById('recommendations');
    
    const data = await fetchRecommendations(faceShape);
    
    if (!data) {
        const fallbackData = haircutRecommendationsFallback[faceShape];
        if (!fallbackData) {
            alert('Unable to load recommendations. Please try again.');
            return;
        }
        displayRecommendationsWithData(fallbackData, measurements, resultsDiv, faceShapeDiv, recommendationsDiv);
    } else {
        displayRecommendationsWithData(data, measurements, resultsDiv, faceShapeDiv, recommendationsDiv);
    }
}

function displayRecommendationsWithData(data, measurements, resultsDiv, faceShapeDiv, recommendationsDiv) {
    let measurementHtml = `
        <div class="measurement-display">
            <h6>📊 Your Face Measurements:</h6>
            <div class="measurement-grid">
                <div class="measure-item">
                    <span class="measure-label">Forehead:</span>
                    <span class="measure-value">${measurements.forehead}%</span>
                </div>
                <div class="measure-item">
                    <span class="measure-label">Cheeks:</span>
                    <span class="measure-value">${measurements.cheeks}%</span>
                </div>
                <div class="measure-item">
                    <span class="measure-label">Jawline:</span>
                    <span class="measure-value">${measurements.jaw}%</span>
                </div>
                <div class="measure-item">
                    <span class="measure-label">Length/Width:</span>
                    <span class="measure-value">${measurements.ratio}</span>
                </div>
            </div>
        </div>
    `;
    
    let html = `
        ${measurementHtml}
        <div class="face-shape-info">
            <h5>${data.shape}</h5>
            <p>${data.description}</p>
        </div>
        <div style="text-align: center; margin: 20px 0;">
            <button class="analysis-btn" onclick="retakeAnalysis()" style="background: #ff6b35;">
                <i class="fas fa-redo"></i> Retake Analysis
            </button>
        </div>
    `;
    
    faceShapeDiv.innerHTML = html;
    
    let recsHtml = '<div class="haircut-recommendations">';
    data.recommendations.forEach(rec => {
        recsHtml += `
            <div class="haircut-card">
                <h6>${rec.style}</h6>
                <p>${rec.description}</p>
                <div class="haircut-details">
                    <span class="maintenance">Maintenance: ${rec.maintenance}</span>
                    ${rec.price ? `<span class="price-tag">${rec.price}</span>` : ''}
                    ${rec.duration ? `<span class="duration-tag">${rec.duration}</span>` : ''}
                </div>
            </div>
        `;
    });
    recsHtml += '</div>';
    
    recommendationsDiv.innerHTML = recsHtml;
    resultsDiv.style.display = 'block';
}

document.addEventListener('DOMContentLoaded', async function() {
    await loadModels();
    
    const startAnalysisBtn = document.getElementById('startAnalysis');
    const video = document.getElementById('video');
    
    if (startAnalysisBtn && video) {
        startAnalysisBtn.addEventListener('click', async function() {
            if (!modelsLoaded) {
                alert('AI models are still loading. Please wait a moment and try again.');
                return;
            }
            
            if (!stream) {
                alert('Camera is not active. Please close and reopen the modal.');
                return;
            }
            
            try {
                startAnalysisBtn.textContent = 'Analyzing...';
                startAnalysisBtn.disabled = true;
                
                const displaySize = { width: video.width, height: video.height };
                const canvas = document.getElementById('overlay');
                
                faceapi.matchDimensions(canvas, displaySize);
                
                const detection = await faceapi
                    .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
                    .withFaceLandmarks()
                    .withFaceExpressions();
                
                if (detection) {
                    const confidence = detection.detection.score;
                    console.log('Detection Confidence:', (confidence * 100).toFixed(1) + '%');
                    
                    if (confidence < 0.85) {
                        const continueAnalysis = confirm(
                            `⚠️ Low Detection Confidence (${(confidence * 100).toFixed(0)}%)\n\n` +
                            `This might not be a real human face or the lighting is poor.\n\n` +
                            `Face-API.js works best with:\n` +
                            `✓ Real human faces (not illustrations/cartoons)\n` +
                            `✓ Good front-facing lighting\n` +
                            `✓ Clear, unobstructed view\n\n` +
                            `Continue anyway? Results may be inaccurate.`
                        );
                        
                        if (!continueAnalysis) {
                            startAnalysisBtn.textContent = 'Start Analysis';
                            startAnalysisBtn.disabled = false;
                            return;
                        }
                    }
                    
                    const resizedDetections = faceapi.resizeResults(detection, displaySize);
                    const ctx = canvas.getContext('2d');
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    faceapi.draw.drawDetections(canvas, resizedDetections);
                    faceapi.draw.drawFaceLandmarks(canvas, resizedDetections);
                    
                    const analysisResult = analyzeFaceShape(resizedDetections.landmarks, canvas, displaySize);
                    currentFaceShape = analysisResult.shape;
                    
                    displayRecommendations(currentFaceShape, analysisResult.measurements);
                    
                    startAnalysisBtn.textContent = 'Analysis Complete!';
                    startAnalysisBtn.style.backgroundColor = '#28a745';
                    
                    setTimeout(() => {
                        if (stream) {
                            stream.getTracks().forEach(track => track.stop());
                            stream = null;
                        }
                    }, 2000);
                } else {
                    alert('No face detected. Please ensure your face is clearly visible and try again.');
                    startAnalysisBtn.textContent = 'Start Analysis';
                    startAnalysisBtn.disabled = false;
                }
                
            } catch (err) {
                console.error('Error during analysis:', err);
                alert('An error occurred during analysis. Please try again.');
                startAnalysisBtn.textContent = 'Start Analysis';
                startAnalysisBtn.disabled = false;
            }
        });
    }
    
    const successMessage = document.getElementById('successMessage');
    if (successMessage) {
        setTimeout(function() {
            successMessage.style.transition = 'opacity 0.5s ease-out';
            successMessage.style.opacity = '0';
            setTimeout(function() {
                successMessage.style.display = 'none';
            }, 500);
        }, 5000);
    }
});
