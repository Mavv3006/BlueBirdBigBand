export type NewsletterRequestType = {
    email: string,
    type: 'adding' | 'removing';
    data_privacy_consent: boolean;
};
