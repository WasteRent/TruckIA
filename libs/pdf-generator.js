#!/usr/bin/env node
const { chromium } = require('playwright');
const fs = require('fs');

async function generatePdf() {
    const args = process.argv.slice(2);
    const htmlFile = args[0];
    const outputFile = args[1];

    // Parse options from stdin as JSON
    let options = {};
    if (!process.stdin.isTTY) {
        const input = fs.readFileSync(0, 'utf-8');
        if (input.trim()) {
            options = JSON.parse(input);
        }
    }

    let html = fs.readFileSync(htmlFile, 'utf-8');

    // If skipFirstPageBottomMargin is set, inject CSS to have minimal margins on first page
    if (options.skipFirstPageBottomMargin) {
        const marginTop = options.marginTop || '6mm';
        const marginRight = options.marginRight || '4mm';
        const marginBottom = options.marginBottom || '20mm';
        const marginLeft = options.marginLeft || '4mm';
        // First page needs minimal margin for footer only (around 12mm for footer space)
        const firstPageMarginBottom = options.footer ? '12mm' : '0';

        const pageStyles = `
            <style>
                @page :first {
                    margin-top: 0;
                    margin-right: 0;
                    margin-bottom: ${firstPageMarginBottom};
                    margin-left: 0;
                }
                @page {
                    margin-top: ${marginTop};
                    margin-right: ${marginRight};
                    margin-bottom: ${marginBottom};
                    margin-left: ${marginLeft};
                }
            </style>
        `;

        // Inject styles into head or at the beginning of html
        if (html.includes('</head>')) {
            html = html.replace('</head>', `${pageStyles}</head>`);
        } else if (html.includes('<body')) {
            html = html.replace('<body', `${pageStyles}<body`);
        } else {
            html = pageStyles + html;
        }
    }

    const browser = await chromium.launch({
        headless: true,
    });

    const page = await browser.newPage();

    await page.setContent(html, {
        waitUntil: 'networkidle',
    });

    // When using @page CSS rules, we need to let CSS handle margins
    const pdfOptions = {
        format: 'A4',
        printBackground: true,
    };

    // Only set margins via Playwright if not using CSS @page rules
    if (!options.skipFirstPageBottomMargin) {
        pdfOptions.margin = {
            top: options.marginTop || '6mm',
            right: options.marginRight || '4mm',
            bottom: options.marginBottom || '8mm',
            left: options.marginLeft || '4mm',
        };
    }

    // Add footer if provided
    if (options.footer) {
        pdfOptions.displayHeaderFooter = true;
        pdfOptions.headerTemplate = '<div></div>';
        pdfOptions.footerTemplate = `
            <div style="width: 100%; font-size: 6pt; padding: 0 10mm; display: flex; justify-content: space-between; align-items: center;">
                <span></span>
                <span style="flex: 1; text-align: center;">${options.footer}</span>
                <span><span class="pageNumber"></span>/<span class="totalPages"></span></span>
            </div>
        `;
    }

    await page.pdf({
        path: outputFile,
        ...pdfOptions,
    });

    await browser.close();

    console.log('PDF generated successfully');
}

generatePdf().catch((error) => {
    console.error('Error generating PDF:', error.message);
    process.exit(1);
});

