export type Route = {
    link?: string,
    isInertia: boolean,
    linkName: string,
    submenu?: {
        link: string,
        linkName: string,
    }[],
}

export type Gates = {
    'route.access-admin': boolean,
    'route.access-intern': boolean,
}

export type FeatureFlags = {
    'newsletter': boolean,
}

/**
 * Call this function with this parameter: `usePage().props.auth.can`.
 */
export function useRoutes(gates?: Gates, feature_flags?: FeatureFlags | unknown): Route[] {
    let routes: Route[] = [
        {link: '/', linkName: 'Home', isInertia: true},
        {
            linkName: 'Aktuelles',
            isInertia: true,
            submenu: [
                {link: '/auftritte', linkName: 'Auftritte'},
                {link: '/presse', linkName: 'Presseinfos'},
                {link: '/buchung', linkName: 'Buchungsinfos'}
            ],
        },
        {
            linkName: 'Band',
            isInertia: true,
            submenu: [
                {link: '/about-us', linkName: 'Über uns'},
                {link: '/musiker', linkName: 'Musiker'},
                {link: '/anfahrt', linkName: 'Anfahrt'}
            ],
        },
        {
            linkName: 'Kontakt',
            isInertia: true,
            submenu: [
                {link: '/kontakt', linkName: 'Kontakt'},
                {link: '/impressum', linkName: 'Impressum'},
                {link: '/datenschutz', linkName: 'Datenschutzerklärung'},
            ],
        },
    ];
    if (feature_flags && feature_flags['newsletter']) {
        routes[3].submenu.push({link: '/newsletter', linkName: 'Newsletter'})
    }
    if (gates["route.access-intern"]) {
        routes.push({
            linkName: 'Intern',
            isInertia: true,
            submenu: [
                {link: '/intern/emails', linkName: 'E-Mail Verteiler'},
                {link: '/intern/songs', linkName: 'Songs'}
            ],
        })
    }
    if (gates["route.access-admin"]) {
        routes.push({link: '/admin', linkName: 'Admin', isInertia: false});
    }

    routes.push({link: '/logout', linkName: 'Logout', isInertia: true});
    routes.push({link: '/login', linkName: 'Login', isInertia: true});

    return routes;
}
