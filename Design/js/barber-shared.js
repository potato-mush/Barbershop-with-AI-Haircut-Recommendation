let servicesCache = null;

async function fetchRecommendations(faceShape) {
    try {
        const response = await fetch(`get_haircut_recommendations.php?face_shape=${faceShape}`);
        const data = await response.json();
        
        if (data.error) {
            console.error('Error fetching recommendations:', data.error);
            return null;
        }
        
        return data;
    } catch (error) {
        console.error('Error fetching recommendations:', error);
        return null;
    }
}

async function fetchServicesPricing() {
    if (servicesCache) {
        return servicesCache;
    }
    
    try {
        const response = await fetch('get_services_pricing.php');
        const data = await response.json();
        
        if (data.success) {
            servicesCache = data.services;
            return data.services;
        } else {
            console.error('Error fetching services:', data.error);
            return null;
        }
    } catch (error) {
        console.error('Error fetching services:', error);
        return null;
    }
}

const haircutRecommendationsFallback = {
    oval: {
        shape: "Oval Face",
        description: "Lucky you! Oval faces are well-balanced and can pull off almost any hairstyle.",
        recommendations: [
            { style: "Textured Crop", description: "A modern, versatile cut that adds texture on top with shorter sides.", maintenance: "Low to Medium" },
            { style: "Pompadour", description: "Classic style with volume on top, perfect for your balanced features.", maintenance: "Medium to High" },
            { style: "Side Part", description: "Timeless and professional, works great with your face shape.", maintenance: "Medium" },
            { style: "Long Layered", description: "If growing it out, layers complement oval faces beautifully.", maintenance: "Medium" }
        ]
    },
    round: {
        shape: "Round Face",
        description: "Round faces benefit from styles that add height and create the illusion of length.",
        recommendations: [
            { style: "High Fade with Quiff", description: "Adds height on top while keeping sides tight to elongate your face.", maintenance: "Medium to High" },
            { style: "Pompadour", description: "The volume adds vertical dimension, perfect for round faces.", maintenance: "Medium to High" },
            { style: "Spiky Top", description: "Upward styling creates height and balances roundness.", maintenance: "Medium" },
            { style: "Angular Fringe", description: "An angular cut adds definition to softer features.", maintenance: "Low to Medium" }
        ]
    },
    square: {
        shape: "Square Face",
        description: "Strong jawline and forehead width. Soften angles with textured, medium-length styles.",
        recommendations: [
            { style: "Textured Medium Length", description: "Adds softness while maintaining masculine structure.", maintenance: "Medium" },
            { style: "Messy Fringe", description: "Breaks up the strong horizontal lines of your face.", maintenance: "Low to Medium" },
            { style: "Side-Swept Undercut", description: "Adds movement while accentuating your strong features.", maintenance: "Medium" },
            { style: "Wavy Top with Fade", description: "Natural waves soften angular features beautifully.", maintenance: "Medium" }
        ]
    },
    long: {
        shape: "Oblong/Long Face",
        description: "Longer face shape benefits from styles that add width and minimize length.",
        recommendations: [
            { style: "Medium Fringe", description: "Shortens face appearance while adding width at sides.", maintenance: "Medium" },
            { style: "Side Swept with Volume", description: "Horizontal volume balances vertical length.", maintenance: "Medium" },
            { style: "Layered Medium Cut", description: "Layers at the sides add width where needed.", maintenance: "Medium" },
            { style: "Textured Crop", description: "Keeps length moderate while adding texture.", maintenance: "Low to Medium" }
        ]
    },
    heart: {
        shape: "Heart/Triangle Face",
        description: "Wider forehead with a pointed chin. Balance with volume at the chin level.",
        recommendations: [
            { style: "Chin-Length Layers", description: "Adds volume at jawline to balance wider forehead.", maintenance: "Medium" },
            { style: "Side Part with Texture", description: "Draws attention away from forehead width.", maintenance: "Medium" },
            { style: "Messy Medium Length", description: "Natural texture balances proportions perfectly.", maintenance: "Low to Medium" },
            { style: "Forward Swept Fringe", description: "Minimizes forehead width while framing face.", maintenance: "Medium" }
        ]
    },
    diamond: {
        shape: "Diamond Face",
        description: "Narrow forehead and chin with wider cheekbones. Add fullness at forehead and chin.",
        recommendations: [
            { style: "Textured Quiff", description: "Adds width at forehead to balance cheekbones.", maintenance: "Medium to High" },
            { style: "Side Part", description: "Classic style that works with your angular features.", maintenance: "Medium" },
            { style: "Fringe with Texture", description: "Adds fullness at forehead area.", maintenance: "Medium" },
            { style: "Medium Length Wavy", description: "Natural waves add width where needed.", maintenance: "Medium" }
        ]
    }
};
