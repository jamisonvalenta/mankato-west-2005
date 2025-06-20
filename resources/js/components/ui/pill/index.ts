import { cva, type VariantProps } from 'class-variance-authority';

export { default as Pill } from './Pill.vue';

export const pillVariants = cva(
    'inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0',
    {
        variants: {
            variant: {
                default: 'bg-primary text-primary-foreground shadow hover:bg-primary/90',
                destructive: 'bg-destructive text-destructive-foreground shadow-sm hover:bg-destructive/90',
                outline: 'border border-input bg-background shadow-sm hover:bg-accent hover:text-accent-foreground',
                secondary: 'bg-secondary text-secondary-foreground shadow-sm hover:bg-secondary/80',
                ghost: 'hover:bg-accent hover:text-accent-foreground',
                green: 'text-primary bg-green-100 text-green-600 border border-green-200',
                amber: 'text-primary bg-amber-100 text-amber-600 border border-amber-200',
                red: 'text-primary bg-red-100 text-red-600 border border-red-200',
                violet: 'text-primary bg-violet-100 text-violet-600 border border-violet-200',
            },
            size: {
                default: 'h-6 px-3 py-1',
                sm: 'h-4 rounded-sm px-3 text-xs',
                lg: 'h-8 rounded-lg px-8',
            },
        },
        defaultVariants: {
            variant: 'default',
            size: 'default',
        },
    },
);

export type PillVariants = VariantProps<typeof pillVariants>;
