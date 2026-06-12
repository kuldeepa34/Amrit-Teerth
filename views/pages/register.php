<?php
/**
 * Register page view — content only.
 */
?>
<main class="flex-grow flex items-center justify-center px-margin-mobile py-stack-lg pt-32 md:pt-40">
<div class="w-full max-w-md">
<div class="glass-panel ambient-shadow rounded-3xl p-8 md:p-10">
<div class="text-center mb-8">
<a href="index.php" class="font-display-lg text-display-lg text-primary">Amrit Teerth</a>
<h1 class="font-headline-sm text-headline-sm text-on-surface mt-4">Begin Your Journey</h1>
<p class="font-body-md text-body-md text-on-surface-variant mt-1">Create an account to book darshan, puja, and more.</p>
</div>
<?php if ($authFlash = \App\Support\Flash::pull('auth')): ?>
<div class="mb-6 rounded-lg px-4 py-3 font-body-md text-body-md <?= $authFlash['type'] === 'error' ? 'bg-error-container text-on-error-container' : 'bg-secondary-container text-on-secondary-container' ?>">
<?= htmlspecialchars($authFlash['message']) ?>
</div>
<?php endif; ?>
<form method="POST" action="register.php" class="space-y-6">
<?= \App\Support\Csrf::field() ?>
<div class="flex flex-col gap-2">
<label for="name" class="font-label-caps text-label-caps text-on-surface-variant">Full Name</label>
<input id="name" name="name" type="text" required autofocus class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3 font-body-md text-body-md text-on-surface focus:border-primary focus:ring-0 transition-colors" placeholder="Your name"/>
</div>
<div class="flex flex-col gap-2">
<label for="email" class="font-label-caps text-label-caps text-on-surface-variant">Email Address</label>
<input id="email" name="email" type="email" required class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3 font-body-md text-body-md text-on-surface focus:border-primary focus:ring-0 transition-colors" placeholder="you@example.com"/>
</div>
<div class="flex flex-col gap-2">
<label for="password" class="font-label-caps text-label-caps text-on-surface-variant">Password</label>
<input id="password" name="password" type="password" required minlength="8" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3 font-body-md text-body-md text-on-surface focus:border-primary focus:ring-0 transition-colors" placeholder="At least 8 characters"/>
</div>
<div class="flex flex-col gap-2">
<label for="confirm" class="font-label-caps text-label-caps text-on-surface-variant">Confirm Password</label>
<input id="confirm" name="confirm" type="password" required minlength="8" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3 font-body-md text-body-md text-on-surface focus:border-primary focus:ring-0 transition-colors" placeholder="Re-enter password"/>
</div>
<button type="submit" class="w-full bg-primary text-on-primary font-label-caps text-label-caps px-8 py-4 rounded-full hover:bg-surface-tint transition-colors shadow-md hover:shadow-lg">Create Account</button>
</form>
<p class="text-center mt-8 font-body-md text-body-md text-on-surface-variant">
                    Already have an account?
                    <a href="login.php" class="text-primary hover:text-secondary transition-colors font-semibold">Sign in</a>
</p>
</div>
</div>
</main>
