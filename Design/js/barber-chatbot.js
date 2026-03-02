
const chatResponses = {
    greetings: ["hello", "hi", "hey", "good morning", "good afternoon", "good evening", "greetings", "howdy", "sup", "yo"],
    faceShapeQuestions: ["face shape", "what shape", "my face", "face type", "shape of my face", "what's my face", "analyze face", "face analysis", "detect face", "identify face"],
    haircutQuestions: ["haircut", "hairstyle", "recommend", "suggestion", "what style", "hair style", "cut", "trim", "best haircut", "which style", "style for me", "hair ideas", "haircut ideas"],
    maintenanceQuestions: ["maintenance", "care", "how to maintain", "upkeep", "take care", "styling", "maintain style", "keep style", "hair care", "how often"],
    pricingQuestions: ["price", "prices", "cost", "costs", "how much", "pricing", "rates", "charges", "charge", "fee", "fees", "payment", "afford"],
    servicesQuestions: ["services", "service", "menu", "what do you offer", "offerings", "available services", "service list", "what services"],
    bookingQuestions: ["book", "appointment", "schedule", "reservation", "available", "availability", "when can", "make appointment", "set appointment"],
    hoursQuestions: ["hours", "open", "close", "opening", "timing", "what time", "when open", "business hours", "work hours"],
    locationQuestions: ["location", "where", "address", "directions", "how to get", "find you"],
    productQuestions: ["product", "pomade", "wax", "gel", "shampoo", "conditioner", "hair product", "styling product"],
    helpQuestions: ["help", "what can you do", "assist", "support", "how does this work", "features", "capabilities"],
    analysisIssues: ["not working", "inaccurate", "wrong", "illustration", "cartoon", "doesn't work", "error", "problem", "issue", "camera", "not detecting"],

    faceShapeDescriptions: {
        oval: ["oval face", "oval", "balanced face", "proportional face", "egg shaped"],
        round: ["round face", "round", "full face", "circular face", "chubby face", "soft features"],
        square: ["square face", "square", "angular face", "strong jaw", "defined jaw", "boxy face", "masculine jaw"],
        long: ["long face", "long", "oblong face", "oblong", "narrow face", "elongated face", "thin face"],
        heart: ["heart face", "heart", "heart shaped", "triangle face", "pointed chin", "wide forehead narrow chin"],
        diamond: ["diamond face", "diamond", "diamond shaped", "wide cheekbones", "narrow forehead and chin"]
    }
};

function toggleChatbox() {
    const chatbox = document.getElementById('chatbotWidget');
    chatbox.classList.toggle('active');
}

function sendMessage() {
    const input = document.getElementById('chatInput');
    const message = input.value.trim();
    
    if (message === '') return;
    
    addMessage(message, 'user');
    
    setTimeout(async () => {
        const response = await generateResponse(message.toLowerCase());
        addMessage(response, 'bot');
    }, 500);
    
    input.value = '';
}

function handleChatEnter(event) {
    if (event.key === 'Enter') {
        sendMessage();
    }
}

function addMessage(text, sender) {
    const messagesDiv = document.getElementById('chatMessages');
    const messageDiv = document.createElement('div');
    messageDiv.className = sender === 'user' ? 'user-message' : 'bot-message';
    // Convert markdown-style formatting to HTML
    const formattedText = text
        .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>') // Bold text
        .replace(/\n/g, '<br>'); // Line breaks
    messageDiv.innerHTML = `<p>${formattedText}</p>`;
    messagesDiv.appendChild(messageDiv);
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
}

function detectFaceShapeFromText(message) {
    for (const [shape, keywords] of Object.entries(chatResponses.faceShapeDescriptions)) {
        if (keywords.some(keyword => message.includes(keyword))) {
            return shape;
        }
    }
    return null;
}

async function generateResponse(message) {
    const describedShape = detectFaceShapeFromText(message);
    if (describedShape) {
        const data = await fetchRecommendations(describedShape);
        if (data && data.recommendations.length > 0) {
            let response = `Great! For a **${data.shape}**, here are my top recommendations:\n\n`;
            data.recommendations.forEach((rec, index) => {
                response += `**${index + 1}. ${rec.style}**\n${rec.description}\nMaintenance: ${rec.maintenance}\n\n`;
            });
            response += "Would you like more details about any of these styles or want to see pricing?";
            return response;
        } else {
            // Fallback to built-in recommendations
            const fallbackData = haircutRecommendationsFallback[describedShape];
            if (fallbackData) {
                let response = `Great! For a **${fallbackData.shape}**, here are my top recommendations:\n\n`;
                fallbackData.recommendations.forEach((rec, index) => {
                    response += `**${index + 1}. ${rec.style}**\n${rec.description}\nMaintenance: ${rec.maintenance}\n\n`;
                });
                response += "Would you like more details about any of these styles or want to see pricing?";
                return response;
            }
        }
    }
    
    if (chatResponses.pricingQuestions.some(phrase => message.includes(phrase))) {
        const services = await fetchServicesPricing();
        if (services && services.length > 0) {
            let priceList = "💈 **Our Services & Pricing:**\n\n";
            services.forEach(service => {
                priceList += `• **${service.service_name}** - ${service.formatted_price} (${service.formatted_duration})\n`;
            });
            priceList += "\nWould you like to book an appointment?";
            return priceList;
        } else {
            return "I'm having trouble fetching our current prices. Please visit our services page or call us for pricing information. Would you like to book an appointment?";
        }
    }
    
    if (chatResponses.servicesQuestions.some(phrase => message.includes(phrase))) {
        const services = await fetchServicesPricing();
        if (services && services.length > 0) {
            let serviceList = "💈 **Our Available Services:**\n\n";
            services.forEach(service => {
                serviceList += `✂️ **${service.service_name}** - ${service.formatted_price}\n   ${service.service_description}\n\n`;
            });
            serviceList += "Ask me about any specific service or type 'pricing' for a quick price list!";
            return serviceList;
        } else {
            return "I'm having trouble fetching our services. Please visit our services page or contact us directly. Would you like to book an appointment?";
        }
    }
    
    const services = await fetchServicesPricing();
    if (services && services.length > 0) {
        for (let service of services) {
            if (message.includes(service.service_name.toLowerCase())) {
                return `✂️ **${service.service_name}**\n\n${service.service_description}\n\n💰 Price: ${service.formatted_price}\n⏱️ Duration: ${service.formatted_duration}\n\nWould you like to book this service?`;
            }
        }
    }
    
    if (chatResponses.bookingQuestions.some(phrase => message.includes(phrase))) {
        return "Great! I'd love to help you book an appointment. You can schedule directly through our website by clicking the 'Book Appointment' button in the navigation menu, or give us a call. Would you like to see our available services first?";
    }
    
    if (chatResponses.hoursQuestions.some(phrase => message.includes(phrase))) {
        return "We're open Monday-Saturday 9:00 AM - 7:00 PM, and Sunday 10:00 AM - 5:00 PM. We accept walk-ins, but appointments are recommended for the best experience!";
    }
    
    if (chatResponses.locationQuestions.some(phrase => message.includes(phrase))) {
        return "You can find our location details in the contact section of our website. We're conveniently located and easy to find. Would you like directions or want to book an appointment?";
    }
    
    if (chatResponses.faceShapeQuestions.some(phrase => message.includes(phrase))) {
        if (currentFaceShape) {
            const data = await fetchRecommendations(currentFaceShape);
            if (data) {
                return `Based on my analysis, you have a ${data.shape}. ${data.description} Would you like specific haircut recommendations?`;
            } else {
                return `Based on my analysis, you have a ${currentFaceShape} face shape. Would you like specific haircut recommendations?`;
            }
        } else {
            return "I can help you determine your face shape in two ways:\n\n1️⃣ **AI Camera Analysis** - Click 'AI Face Analysis' for automatic detection\n2️⃣ **Describe your face** - Tell me if you have an oval, round, square, long, heart, or diamond shaped face\n\nWhich would you prefer?";
        }
    }
    
    if (chatResponses.haircutQuestions.some(phrase => message.includes(phrase))) {
        if (currentFaceShape) {
            const data = await fetchRecommendations(currentFaceShape);
            if (data && data.recommendations.length > 0) {
                const styles = data.recommendations.slice(0, 3).map(r => r.style).join(', ');
                return `For your ${data.shape}, I recommend: ${styles}. Would you like more details about any of these?`;
            } else {
                return "I'd love to recommend the perfect haircut! First, use our AI Face Analysis feature so I can give you personalized recommendations.";
            }
        } else {
            return "I'd love to recommend a haircut! To give you the best suggestions, please:\n\n1️⃣ **Describe your face shape** (e.g., 'I have a round face')\n2️⃣ Or use our **AI Face Analysis** with your camera\n\nWhich works better for you?";
        }
    }
    
    if (chatResponses.maintenanceQuestions.some(phrase => message.includes(phrase))) {
        return "Great question! Maintenance varies by style: Low maintenance cuts need a trim every 6-8 weeks. Medium maintenance styles need styling daily and trims every 4-6 weeks. High maintenance cuts require daily styling, products, and trims every 3-4 weeks. Which level suits your lifestyle?";
    }
    
    if (chatResponses.productQuestions.some(phrase => message.includes(phrase))) {
        return "We use and sell premium grooming products including pomades, waxes, beard oils, and styling products. Each product is carefully selected for quality and results. Our barbers can recommend the best products for your hair type and style!";
    }
    
    if (chatResponses.helpQuestions.some(phrase => message.includes(phrase))) {
        return "I'm your AI barbershop assistant! I can help with:\n\n📸 **AI Face Analysis** - Use camera for automatic face shape detection\n📝 **Text Recommendations** - Describe your face (e.g., 'I have a round face') and get recommendations\n💈 **Haircut suggestions** based on your face shape\n💰 **Pricing information** for all services\n📅 **Booking appointments**\n✂️ **Style maintenance tips**\n🎯 **Product recommendations**\n\nWhat would you like to know?";
    }
    
    if (chatResponses.analysisIssues.some(phrase => message.includes(phrase))) {
        return "The AI face detector works best with REAL human faces in good lighting. It won't work accurately with: ❌ Illustrations or cartoons, ❌ Photos on screens, ❌ Poor lighting, ❌ Side angles. For best results, use your actual face directly in front of the camera with good lighting!";
    }
    
    if (chatResponses.greetings.some(word => message.includes(word))) {
        return "Hello! I'm here to help you find the perfect haircut. You can:\n\n1️⃣ Use our **AI Face Analysis** with your camera\n2️⃣ Simply **describe your face** (e.g., 'I have a round face')\n3️⃣ Ask about **pricing and services**\n\nHow would you like to proceed?";
    }
    
    return "I can help you with:\n\n• **Haircut recommendations** - Just describe your face shape (oval, round, square, long, heart, or diamond)\n• **AI Face Analysis** - Use camera for automatic detection\n• **Pricing & Services** - Ask about our services and pricing\n• **Appointments** - Book your visit\n• **Style tips** - Maintenance and care advice\n\nTry saying something like 'I have a square face' or 'What are your prices?'";
}

function openAppointmentPopup() {
    document.getElementById('registrationPopup').style.display = 'block';
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('appointment_date').setAttribute('min', today);
}
