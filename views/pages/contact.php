<?php
/**
 * Contact page view — content only.
 * Rendered inside includes/layout.php (head + header above, footer below).
 */
?>
<main class="flex-grow pt-24 md:pt-32 pb-stack-lg">
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
<!-- Page Header -->
<div class="text-center mb-stack-lg max-w-2xl mx-auto">
<h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-on-surface mb-4">Reach Out to the Divine</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant">We are here to assist you on your spiritual journey. Whether you seek guidance, wish to book a specific ritual, or simply have a question, our dedicated team is ready to connect.</p>
</div>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter items-start">
<!-- Contact Information Column -->
<div class="lg:col-span-5 flex flex-col gap-unit h-full">
<div class="glass-panel ambient-shadow rounded-xl p-8 flex flex-col justify-center h-full relative overflow-hidden group">
<!-- Decorative bg -->
<div class="absolute -right-10 -bottom-10 opacity-5 pointer-events-none transition-transform duration-700 group-hover:scale-110">
<span class="material-symbols-outlined text-[200px]">spa</span>
</div>
<h2 class="font-headline-sm text-headline-sm text-on-surface mb-8">Contact Information</h2>
<div class="flex flex-col gap-6">
<div class="flex items-start gap-4">
<div class="w-12 h-12 rounded-full bg-surface-container-highest flex items-center justify-center text-primary flex-shrink-0">
<span class="material-symbols-outlined fill">mail</span>
</div>
<div>
<h3 class="font-label-caps text-label-caps text-on-surface-variant mb-1">Email Inquiry</h3>
<a class="font-body-md text-body-md text-on-surface hover:text-primary transition-colors" href="mailto:blessings@amritteerth.com">blessings@amritteerth.com</a>
</div>
</div>
<div class="flex items-start gap-4">
<div class="w-12 h-12 rounded-full bg-surface-container-highest flex items-center justify-center text-primary flex-shrink-0">
<span class="material-symbols-outlined fill">call</span>
</div>
<div>
<h3 class="font-label-caps text-label-caps text-on-surface-variant mb-1">Temple Office</h3>
<a class="font-body-md text-body-md text-on-surface hover:text-primary transition-colors" href="tel:+18005550199">+1 (800) 555-0199</a>
</div>
</div>
<div class="flex items-start gap-4">
<div class="w-12 h-12 rounded-full bg-surface-container-highest flex items-center justify-center text-primary flex-shrink-0">
<span class="material-symbols-outlined fill">location_on</span>
</div>
<div>
<h3 class="font-label-caps text-label-caps text-on-surface-variant mb-1">Sanctuary Address</h3>
<p class="font-body-md text-body-md text-on-surface">108 Lotus Lane, Serenity Valley,<br/>Spiritual District, CA 90210</p>
</div>
</div>
</div>
<div class="mt-12">
<h3 class="font-label-caps text-label-caps text-on-surface-variant mb-4">Follow Our Journey</h3>
<div class="flex gap-4">
<?php foreach ($SOCIAL_LINKS as $social): ?>
<a class="w-10 h-10 rounded-full border border-outline-variant flex items-center justify-center text-on-surface-variant hover:bg-primary hover:text-on-primary hover:border-primary transition-all" href="<?= htmlspecialchars($social['href']) ?>" aria-label="<?= htmlspecialchars($social['label']) ?>"<?= str_starts_with($social['href'], 'http') ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
<span class="material-symbols-outlined"><?= htmlspecialchars($social['icon']) ?></span>
</a>
<?php endforeach; ?>
</div>
</div>
</div>
</div>
<!-- Form Column -->
<div class="lg:col-span-7">
<div class="bg-surface-container-lowest rounded-xl p-6 md:p-10 shadow-[0_20px_40px_rgba(11,27,54,0.02)] border border-outline-variant/30 relative">
<h2 class="font-headline-md text-headline-md text-on-surface mb-2">Send a Message</h2>
<p class="font-body-md text-body-md text-on-surface-variant mb-8">Fill out the details below and our spiritual guides will respond within 24 hours.</p>
<?php if ($contactFlash = \App\Support\Flash::pull('contact')): ?>
<div class="mb-8 rounded-lg px-4 py-3 font-body-md text-body-md <?= $contactFlash['type'] === 'error' ? 'bg-error-container text-on-error-container' : 'bg-secondary-container text-on-secondary-container' ?>">
<?= htmlspecialchars($contactFlash['message']) ?>
</div>
<?php endif; ?>
<form action="contact-submit.php" class="space-y-8" method="POST">
<?= \App\Support\Csrf::field() ?>
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
<div class="relative">
<input class="form-input-minimal w-full font-body-md text-body-md text-on-surface placeholder-transparent peer" id="fullName" name="fullName" placeholder="Full Name" required type="text"/>
<label class="absolute left-0 top-3 text-on-surface-variant font-body-md text-body-md transition-all peer-focus:-top-4 peer-focus:text-label-caps peer-focus:font-label-caps peer-focus:text-primary peer-valid:-top-4 peer-valid:text-label-caps peer-valid:font-label-caps pointer-events-none" for="fullName">Full Name</label>
</div>
<div class="relative">
<input class="form-input-minimal w-full font-body-md text-body-md text-on-surface placeholder-transparent peer" id="emailAddress" name="emailAddress" placeholder="Email Address" required type="email"/>
<label class="absolute left-0 top-3 text-on-surface-variant font-body-md text-body-md transition-all peer-focus:-top-4 peer-focus:text-label-caps peer-focus:font-label-caps peer-focus:text-primary peer-valid:-top-4 peer-valid:text-label-caps peer-valid:font-label-caps pointer-events-none" for="emailAddress">Email Address</label>
</div>
</div>
<div class="relative">
<select class="form-input-minimal w-full font-body-md text-body-md text-on-surface appearance-none bg-transparent cursor-pointer peer focus:ring-0" id="serviceInterest" name="serviceInterest">
<option class="text-on-surface-variant" disabled selected value="">Select a Service of Interest</option>
<option class="text-on-surface bg-surface-container-lowest" value="puja">Personal Puja</option>
<option class="text-on-surface bg-surface-container-lowest" value="darshan">Special Darshan Booking</option>
<option class="text-on-surface bg-surface-container-lowest" value="astrology">Astrology Consultation</option>
<option class="text-on-surface bg-surface-container-lowest" value="general">General Inquiry</option>
</select>
<div class="absolute right-0 top-3 pointer-events-none text-on-surface-variant">
<span class="material-symbols-outlined">expand_more</span>
</div>
</div>
<div class="relative">
<textarea class="form-input-minimal w-full font-body-md text-body-md text-on-surface placeholder-transparent peer resize-none" id="message" name="message" placeholder="Your Message" required rows="4"></textarea>
<label class="absolute left-0 top-3 text-on-surface-variant font-body-md text-body-md transition-all peer-focus:-top-4 peer-focus:text-label-caps peer-focus:font-label-caps peer-focus:text-primary peer-valid:-top-4 peer-valid:text-label-caps peer-valid:font-label-caps pointer-events-none" for="message">Your Message</label>
</div>
<div class="pt-4">
<button class="w-full md:w-auto bg-primary text-on-primary px-8 py-4 rounded-lg font-label-caps text-label-caps hover:bg-surface-tint transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2" type="submit">
                                    Send Message
                                    <span class="material-symbols-outlined text-[18px]">send</span>
</button>
</div>
</form>
</div>
</div>
</div>
<!-- Map Section -->
<div class="mt-stack-lg rounded-xl overflow-hidden h-[400px] relative border border-outline-variant/30 shadow-md">
<img alt="Map showing Amrit Teerth Sanctuary location" class="w-full h-full object-cover opacity-80" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAjFpEjnmK1P-O-_tnUKr1qP6m_Ebuft0WyV9Okp47__lcqpXuNZG8MDiarlXr0dCCzwzAj2YxFcyoZhjKo5sFyNh4it3vVs8v7Kl2fTMjF2LEK8_O1B6fTNcFf18fuq5jW9tLhoUW9tFN9jNp5T0yMyFm__2pE8Av8GO3xA860HUXRr6VLIFiYrJOp1BDtw_MkmlLufdghvi4SufCw9cCJ_tZ7C59VhJGbGv9YUDMyUgUrRKF8eahAOsy2f2w6BiV9CvSQvDdDI3g"/>
<div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest/80 to-transparent pointer-events-none"></div>
<div class="absolute bottom-6 left-6 glass-panel ambient-shadow px-6 py-4 rounded-lg flex items-center gap-3">
<div class="w-3 h-3 rounded-full bg-primary animate-pulse"></div>
<span class="font-label-caps text-label-caps text-on-surface">Amrit Teerth Sanctuary</span>
</div>
</div>
</div>
</main>
